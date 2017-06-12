<?php

use common\db\TranslatedMessagesMigration;

class m160711_002353_miranda_pets_spanish_translations extends TranslatedMessagesMigration
{
    public function getLanguage()
    {
        return 'es-ES';
    }

    public function getCategory()
    {
        return 'miranda/post';
    }

    public function getTranslations()
    {
        return [
            'Create Tag' => 'Crear etiqueta',
            'Update Tag' => 'Actualizar etiqueta',
            'No posts found.' => 'No se encontraron publicaciones',
            'Post' => 'Publicaciones',
            'Posted in' => 'Publicado el',
            'Posts Activity' => 'Actividad en publicaciones',
            'Posts' => 'Publicaciones',
            'Tag' => 'Etiqueta',
            'Tags' => 'Etiquetas',
            'Cover' => 'Portada',
            'Thumbnail' => 'Miniatura',
            'Carousel' => 'Carrusel'
        ];
    }
}
