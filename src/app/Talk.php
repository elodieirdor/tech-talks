<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Talk",
 *     description="Talk",
 *     type="object"
 * )
 * Class Talk
 * @package App
 */
class Talk extends Model
{
    /**
     * @OA\Property(
     *     title="id",
     *     property="id",
     *     description="ID of the talk",
     *     type="number",
     * )
     */

    /**
     * @OA\Property(
     *     title="topic",
     *     property="topic",
     *     description="Topic of the talk",
     *     type="string",
     * )
     */

    /**
     * @OA\Property(
     *     title="description",
     *     property="description",
     *     description="Description of the talk",
     *     type="string",
     * )
     */

    /**
     * @OA\Property(
     *     title="date",
     *     property="date",
     *     description="Date",
     *     type="string",
     *     format="date",
     * )
     */

    /**
     * @OA\Property(
     *     title="status",
     *     property="status",
     *     description="status",
     *     type="string",
     *     enum={"published", "draft"}
     * )
     */

    const STATUS_PUBLISHED = 'published';
    const STATUS_DRAFT = 'draft';
    const STATUS = [self::STATUS_PUBLISHED, self::STATUS_DRAFT];

    protected $fillable = [
        'topic', 'description', 'date', 'status',
    ];

    protected $visible = [
        'id', 'topic', 'description', 'date', 'status',
    ];
}
