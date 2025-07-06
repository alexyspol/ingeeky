<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ProductsController extends BaseController
{
    protected $productModel;
    protected $currentUser;

    public function __construct()
    {
        helper('auth');

        $this->productModel = new ProductModel();
        $this->currentUser = auth()->user();
    }

    // GET /products
    public function index()
    {
        // Customers see only their products
        if ($this->currentUser->inGroup('user')) {
            $products = $this->productModel->where('user_id', $this->currentUser->id)->findAll();
        } else {
            // Employees see everything
            $products = $this->productModel->findAll();
        }

        return view('products/index', ['products' => $products]);
    }

    // GET /products/new
    public function new()
    {
        $userModel = auth()->getProvider();

        // Join with the auth_groups_users table and filter by group name
        $customers = $userModel
            ->select('users.*') // Select all columns from the users table
            ->join('auth_groups_users agu', 'agu.user_id = users.id')
            ->where('agu.group', 'user') // Filter by the group name 'user'
            ->findAll();

        return view('products/new', [
            'customers' => $customers,
        ]);
    }

    // POST /products
    public function create()
    {
        $data = $this->request->getPost();

        if (!$this->validate(['name' => 'required|min_length[3]', 'user_id' => 'required|integer'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->productModel->insert([
            'name'    => $data['name'],
            'user_id' => $data['user_id'],
        ]);

        return redirect()->to('/products')->with('success', 'Product created.');
    }

    // GET /products/{id}/edit
    public function edit($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('products/edit', ['product' => $product]);
    }

    // PUT /products/{id}
    public function update($id)
    {
        if (!$this->validate(['name' => 'required|min_length[3]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->productModel->update($id, ['name' => $this->request->getPost('name')]);
        return redirect()->to('/products')->with('success', 'Product updated.');
    }

    // DELETE /products/{id}
    public function delete($id)
    {
        $this->productModel->delete($id);
        return redirect()->to('/products')->with('success', 'Product deleted.');
    }
}
