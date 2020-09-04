<?php 

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;   

class BaseRepository
{
  /**
   * @var Model
   */
  protected $model;

  public function __construct(Model $model)
  {
    $this->model = $model;
  }
}