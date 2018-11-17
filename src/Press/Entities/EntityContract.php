<?php

namespace Orchid\Press\Entities;

/**
 * Interface EntityContract.
 */
interface EntityContract
{
    /**
     * Basic statuses possible for the object.
     *
     * @return array
     */
    public function status(): array;

    /**
     * Request Validation.
     *
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function isValid(): array;

    /**
     * Validation Request Rules.
     *
     * @return array
     */
    public function rules(): array;

    /**
     * Registered fields for main.
     *
     * @return mixed
     */
    public function main(): array;

    /**
     * Registered fields for filling.
     *
     * @return mixed
     */
    public function fields(): array;

    /**
     * Registered fields for options.
     *
     * @return mixed
     */
    public function options(): array;
}
