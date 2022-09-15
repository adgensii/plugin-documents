<?php

namespace Botble\Documents\Models;

use Botble\Base\Models\BaseModel;

class DocumentsMetaTranslation extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'documents_meta_translations';

    /**
     * @var array
     */
    protected $fillable = [
        'lang_code',
        'document_meta_id',
        'images',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'documents' => 'json',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
}
