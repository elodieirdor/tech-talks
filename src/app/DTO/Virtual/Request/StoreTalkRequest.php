<?php


namespace App\DTO\Virtual\Request;

/**
 * @OA\Schema(
 *     title="Store Talk request",
 *     description="Store User request body data",
 *     type="object",
 *     required={"topic", "description", "date"}
 * )
 */
class StoreTalkRequest
{
    /**
     * @OA\Property(
     *     title="topic",
     *     description="Topic",
     *     type="string",
     *     maximum=80,
     * )
     *
     * @var string
     */
    public string $topic;

    /**
     * @OA\Property(
     *     title="description",
     *     description="Description of the talk",
     *     type="string",
     * )
     *
     * @var string
     */
    public string $description;

    /**
     * @OA\Property(
     *     title="date",
     *     description="Date : must be 1st tuesday of an even month (max in 6 months)",
     *     type="string",
     *     format="date",
     * )
     *
     * @var string
     */
    public string $date;

}
