<?php
/**
 * Created by PhpStorm.
 * User: OLGAYELENA
 * Date: 14/7/2016
 * Time: 9:42 AM
 */

namespace backend\widgets;

use common\models\PostTag;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\web\session;
use yii\helpers\ArrayHelper;


class SeoAnalyzer extends Widget
{

    public $height = 'auto';

    public $width = '12';

    public $position = 'left';

    public $title = [];

    public $content = [];

    public $slug;

    public $tagValues;

    public $selectedContent;

    public $selectedTitle;

    public $selectedSlug;

    public $selectedTags;


    public function init()
    {

        if (!is_array($this->content)) {
            throw new InvalidConfigException('Content must be an array');
        }

        if (!is_array($this->title)) {
            throw new InvalidConfigException('Title must be an array');
        }

        $selectedSlug = str_replace('-', ' ', $this->slug);
        $selectedSlug = explode(',', $selectedSlug);
        $this->selectedSlug = $selectedSlug;

        if (!empty($this->tagValues)) {

            $selectedTags = str_replace('[', '', $this->tagValues);
            $selectedTags = str_replace(']', '', $selectedTags);
            $selectedTags = explode(',', $selectedTags);
            $selectedTags = str_replace('"', '', $selectedTags);
            $selectedTags = PostTag::find()->where(['id' => $selectedTags])->all();
            $selectedTags = ArrayHelper::map($selectedTags, 'id', 'title');
            $this->selectedTags = $selectedTags;

        }

        parent::init(); // TODO: Change the autogenerated stub
    }

    public function checkTitleInContent($title, $selectedContent)
    {

        $selectedTitle = str_replace(' ', ',', $title);

        $selectedTitle = explode(',', $selectedTitle);

        $words = [];

        foreach ($selectedTitle as $titles) {

            $explodedTitle = explode(' ', $titles);

            foreach ($explodedTitle as $titleWord) {

                if (strlen($titleWord) >= 4) {

                    $words[] = $titleWord;

                }
            }

        }

        $i = 0;

        foreach ($words as $word) {

            if (preg_match("/{$word}/i", $selectedContent)) {

                $i++;
            }

        }

        if ($i >= count($words)) {

            return true;
        }

        return false;

    }


    public function checkTitleInSlug($title, $selectedSlug)
    {

        $words = [];

        foreach ($selectedSlug as $slug) {

            $explodedSlug = explode(' ', $slug);

            foreach ($explodedSlug as $slugsWord) {

                if (strlen($slugsWord) >= 4) {

                    $words[] = $slugsWord;

                }
            }

        }

        $i = 0;

        foreach ($words as $word) {

            if (preg_match("/{$word}/i", $title)) {

                $i++;
            }

        }

        if ($i >= count($words)) {

            return true;
        }

        return false;

    }

    public function checkTitleInTags($title, $selectedTags)
    {

        $words = [];

        foreach ($selectedTags as $tag) {

            $explodedTag = explode(' ', $tag);

            foreach ($explodedTag as $tagWord) {

                if (strlen($tagWord) >= 4) {

                    $words[] = $tagWord;

                }
            }

        }

        $i = 0;

        foreach ($words as $word) {

            if (preg_match("/{$word}/i", $title)) {

                $i++;
            }

        }

        if ($i >= count($words)) {

            return true;
        }

        return false;
    }

    public function checkSlugInContent($selectedSlug, $selectedContent)
    {

        $words = [];

        foreach ($selectedSlug as $slug) {

            $explodedSlug = explode(' ', $slug);

            foreach ($explodedSlug as $slugsWord) {

                if (strlen($slugsWord) >= 4) {

                    $words[] = $slugsWord;

                }
            }

        }

        $i = 0;

        foreach ($words as $word) {

            if (preg_match("/{$word}/i", $selectedContent)) {

                $i++;
            }

        }

        if ($i >= count($words)) {

            return true;
        }

        return false;
    }

    public function checkSlugInTag($slug, $selectedTags)
    {

        $words = [];

        foreach ($selectedTags as $tag) {

            $explodedTag = explode(' ', $tag);

            foreach ($explodedTag as $tagWord) {

                if (strlen($tagWord) >= 4) {

                    $words[] = $tagWord;

                }
            }

        }

        $i = 0;

        foreach ($words as $word) {

            if (preg_match("/{$word}/i", $slug)) {

                $i++;
            }

        }

        if ($i >= count($words)) {

            return true;
        }

        return false;

    }

    public function checkContentInTag($selectedTags, $selectedContent)
    {

        $words = [];

        foreach ($selectedTags as $tag) {

            $explodedTag = explode(' ', $tag);

            foreach ($explodedTag as $tagWord) {

                if (strlen($tagWord) >= 4) {

                    $words[] = $tagWord;

                }
            }

        }

        $i = 0;

        foreach ($words as $word) {

            if (preg_match("/{$word}/i", $selectedContent)) {

                $i++;
            }

        }

        if ($i >= count($words)) {

            return true;
        }

        return false;
    }

    public function get_Url($selectedContent)
    {
        $selectedContent = explode(" ", $selectedContent);

        foreach ($selectedContent as $cont) {
            $count = 0;
            $explodedCont = explode(' ', $cont);
            $stringUrl = $explodedCont;
            $string_resul = preg_replace("/((http|https|www)[^\s]+)/", '<a href="$1">$0</a>', $stringUrl, -1, $count);
            if ($count > 0) {
                return true;

            }

        }
        return false;
    }

    public function countCaracter($title)
    {

        $count = 0;

        $selectedTitle = str_replace(' ', ',', $title);

        $count = strlen($selectedTitle);

        return $count;

    }


    public function run()
    {
        return $this->render('seoanalyzer',
            [
                'height' => $this->height,
                'width' => $this->width,
                'position' => $this->position,
                'title' => $this->title,
                'selectedTags' => $this->selectedTags,
                'content' => $this->content,
                'selectedSlug' => $this->selectedSlug,

            ]);
    }


}