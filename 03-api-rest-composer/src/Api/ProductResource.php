<?php

namespace App\Api;

class ProductResource extends Resource
{
  public function __construct()
  {
    parent::__construct();
    $this->tableName = 'product';
    $this->resourceName = 'products';
  }
}
