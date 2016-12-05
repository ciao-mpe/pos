<?php

//Product Form Validation Helper
use Pos\Helpers\Validator\Forms\ProductForm;

//Add Product
$app->get('/admin/product/add', $auth(true), $admin_staff(), function() use ($app) {

    $app->render('admin/product/add.php');

})->name('product_add');

$app->post('/admin/product/add', $auth(true), $admin_staff(), function() use ($app) {

    $request = $app->request;

    // all errors
    $errors = null;
    $image_errors = null;

    $v = $app->validator->validate(ProductForm::rules());
    $file_status = true;
    $image_name = "";

    //checking if has image
    if ($v->validate() && !empty($_FILES['image'])) {

        //uploading an image
        $handle = new upload($_FILES['image']);

        if ($handle->uploaded) {
            $path = APP_PATH.$app->config->get('app.images').'/products/';

            $image_name = md5(uniqid(time()+3600));

            $handle->file_new_name_body = $image_name;
            $handle->file_new_name_ext = 'jpeg';
            $handle->allowed = array('image/*');
            $handle->forbidden = array('application/*');
            $handle->file_max_size = '1000000';
            $handle->image_resize  = true;
            $handle->image_x = 480;
            $handle->image_ratio_y = true;
            $handle->process($path);

            if ($handle->processed) {
                $handle->clean();
            } else {
                $file_status = false;
                $image_errors = $handle->error;
                $handle->clean();
            }
        }
    }

    //validate form attributes and check file upload status
    if ($v->validate() && $file_status) {

        $product = $app->db->insert('product', [
            'title' => $request->post('title'),
            'slug' => '',
            'code' => $request->post('code'),
            'description' => $request->post('description'),
            'price' => $request->post('price'),
            'quantity' => $request->post('quantity'),
            'reorder' => $request->post('reorder'),
            'image' => $image_name
        ]);

        $app->db->update('product', $product->lastInsertid(), [
            'slug' => create_slug($request->post('title')).'-'.$product->lastInsertid()
        ]);

        $app->flash('success', 'Product stored successful');
        $app->response->redirect($app->urlFor('admin_home'));
            
    }else {
        $errors = $v->errors();
    }

    $app->render('admin/product/add.php', [
        'request' => $request,
        'errors' => $errors,
        'imgerr' => $image_errors
    ]);

});

//Edit Product
$app->get('/admin/product/edit/:id', $auth(true), $admin_staff(), function($id) use ($app) {

    $product = $app->db->getByid('product', $id)->first();

    if ($product) {

        $app->render('admin/product/edit.php', [
            'product' => $product
        ]);
        
    } else {
        $app->flash('error', 'Product id is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

})->name('product_edit');

$app->post('/admin/product/edit/:id', $auth(true), $admin_staff(), function($id) use ($app) {

    $product = $app->db->getByid('product', $id)->first();

    if ($product) {

        $request = $app->request;

        // all errors
        $errors = null;
        $image_errors = null;

        $v = $app->validator->validate(ProductForm::rules($product->code));
        $file_status = true;
        $image_is_changed = false;
        $image_name = "";

        //checking if has image
        if ($v->validate() && !empty($_FILES['image'])) {

            //uploading an image
            $handle = new upload($_FILES['image']);

            if ($handle->uploaded) {
                $path = APP_PATH.$app->config->get('app.images').'/products/';

                $image_name = md5(uniqid(time()+3600));

                $handle->file_new_name_body = $image_name;
                $handle->file_new_name_ext = 'jpeg';
                $handle->allowed = array('image/*');
                $handle->forbidden = array('application/*');
                $handle->file_max_size = '1000000';
                $handle->image_resize  = true;
                $handle->image_x = 480;
                $handle->image_ratio_y = true;
                $handle->process($path);

                if ($handle->processed) {
                    $image_is_changed = true;
                    if (file_exists($path.$product->image.'.jpeg')) {
                        unlink($path.$product->image.'.jpeg');
                    }
                    $handle->clean();
                } else {
                    $file_status = false;
                    $image_errors = $handle->error;
                    $handle->clean();
                }
            }
        }

        //validate form attributes and check file upload status
        if ($v->validate() && $file_status) {

            $app->db->update('product', $product->id, [
                'title' => $request->post('title'),
                'slug' => create_slug($request->post('title')).'-'.$product->id,
                'code' => $request->post('code'),
                'description' => $request->post('description'),
                'price' => $request->post('price'),
                'quantity' => $request->post('quantity'),
                'reorder' => $request->post('reorder'),
                'image' => ($image_is_changed) ? $image_name : $product->image
            ]);

            $app->flash('success', 'Product updated successful');
            $app->response->redirect($app->urlFor('product_edit', ['id' => $product->id]));
                
        }else {
            $errors = $v->errors();
        }

        $app->render('admin/product/edit.php', [
            'product' => $product,
            'request' => $request,
            'errors' => $errors,
            'imgerr' => $image_errors
        ]);
        
    } else {
        $app->flash('error', 'Product id is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

});

//Delete Product
$app->get('/admin/product/delete/:id', $auth(true), $admin(), function($id) use ($app) {

    $product = $app->db->getByid('product', $id)->first();

    if ($product) {

        $path = APP_PATH.$app->config->get('app.images').'/products/';
        if (file_exists($path.$product->image.'.jpeg')) {
           unlink($path.$product->image.'.jpeg');
        }
        $app->db->delete('product', $product->id);

        $app->flash('success', 'Product Deleted successful');
        $app->response->redirect($app->urlFor('admin_home'));

    }else {
        $app->flash('error', 'Product id is invalid');
        $app->response->redirect($app->urlFor('admin_home'));
    }

})->name('product_delete');

//All Products
$app->get('/admin/products', $auth(true), $admin_staff(), function() use ($app) {

    $request = $app->request;

    if ($request->isAjax()) {
        $start = 0;
        $length = 10;
        $search_title = $request->get('columns')[1]['search']['value'];
        $search_code = $request->get('columns')[2]['search']['value'];
        $query = "";

        $bindings = [];

        if ($request->get('start')) {
            $start = $request->get('start');
        }
        if ($request->get('length')) {
            $length = $request->get('length');
        }

        if($search_title != NULL) {
            $query = "title LIKE ? ORDER BY id DESC";
            $bindings = ['%'.$search_title.'%'];
        } else if($search_code != NULL) {
            $query = "code = ?";
            $bindings = [$search_code];
        } else {
            $query = "ORDER BY id DESC LIMIT ".$start.", ".$length;
        }

        $products = $app->db->getAll('product', $query, $bindings);
        
        echo json_encode([
            "recordsTotal" => $products->count(),
            "recordsFiltered" => $products->count(),
            'data' => $products->toArray()
        ]);
        exit();
    }
    $app->render('admin/product/all.php', [
        'return_url' => ($request->get('return') == "purchase_order") ? 'true' : 'false'
    ]);

})->name('product_all');

