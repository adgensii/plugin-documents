<?php

use Botble\Documents\Repositories\Interfaces\DocumentsMetaInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

if (!function_exists('documents_meta_data')) {
    /**
     * @param Model $object
     * @param array $select
     * @return array
     */
    function documents_meta_data($object, array $select = ['documents_meta.id', 'documents_meta.documents']): array
    {
        $meta = app(DocumentsMetaInterface::class)->getFirstBy([
            'reference_id'   => $object->id,
            'reference_type' => get_class($object),
        ], $select);

        if (!empty($meta)) {
            return $meta->documents ? (array)$meta->documents : [];
        }

        return [];
    }
}