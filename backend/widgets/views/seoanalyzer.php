<?php
/**
 * Created by PhpStorm.
 * User: OLGAYELENA
 * Date: 14/7/2016
 * Time: 9:32 AM
 */

use backend\widgets;

/* @var $this yii\web\View */
?>


<?php foreach (Yii::$app->params['languages'] as $language => $languageName): ?>

    <div data-toggle="multilang" data-lang="<?= $language ?>"
         class="<?= ((Yii::$app->language == $language) ? 'in' : '') ?>">

        <h3><?= Yii::t('miranda/seoanalizer', 'Content Analyzer') ?> [<?= $languageName ?>] </h3>

        <?php
        $checkTitleInContent = widgets\SeoAnalyzer::checkTitleInContent($title[$language], $content[$language]);
        $checkTitleInSlug = widgets\SeoAnalyzer::checkTitleInSlug($title[$language], $selectedSlug);
        if (!empty($selectedTags)) {
            $checkContentInTag = widgets\SeoAnalyzer::checkContentInTag($selectedTags, $content[$language]);
            $checkTitleInTags = widgets\SeoAnalyzer::checkTitleInTags($title[$language], $selectedTags);
        }
        $checkSlugInContent = widgets\SeoAnalyzer::checkSlugInContent($selectedSlug, $content[$language]);
        $get_Url = widgets\SeoAnalyzer::get_Url($content[$language]);
        $countCaracter = widgets\SeoAnalyzer::countCaracter($title[$language]);
        ?>



        <?php
        if ($checkTitleInContent == true) {
            $Text = Yii::t("miranda/seoanalizer", "the title keywords found in the content");
            echo '<i class="fa  fa-check-circle   pull-left" style="color:green"></i>';
            echo '<div style="Color:black">' . $Text . '</div>';
        } elseif ($checkTitleInContent == false) {
            $Text = Yii::t("miranda/seoanalizer", "the key words of the title are not in the content");
            echo '<i class="fa  fa-check-circle   pull-left" style="color:red"></i>';
            echo '<div style="Color:black">' . $Text . '</div>';
        }
        ?>



        <?php
        if ($checkTitleInSlug == true) {
            $Text = Yii::t("miranda/seoanalizer", "the key words title are in the slug");
            echo '<i class="fa  fa-check-circle   pull-left" style="color:green"></i>';
            echo '<div style="Color:black">' . $Text . '</div>';
        } elseif ($checkTitleInSlug == false) {
            $Text = Yii::t("miranda/seoanalizer", "the key words of the title are not found in the slug");
            echo '<i class="fa  fa-check-circle   pull-left" style="color:red"></i>';
            echo '<div style="Color:black">' . $Text . '</div>';
        }
        ?>




        <?php
        if ($checkSlugInContent == true) {
            $Text = Yii::t("miranda/seoanalizer", "the slug keywords found in the content");
            echo '<i class="fa  fa-check-circle   pull-left" style="color:green"></i>';
            echo '<div style="Color:black">' . $Text . '</div>';
        } elseif ($checkSlugInContent == false) {
            $Text = Yii::t("miranda/seoanalizer", "the key words of the slug are not in the content");
            echo '<i class="fa  fa-check-circle   pull-left" style="color:red"></i>';
            echo '<div style="Color:black">' . $Text . '</div>';
        }
        ?>



        <?php
        if ($get_Url == true) {
            $Text = Yii::t("miranda/seoanalizer", "the content has external links");
            echo '<i class="fa  fa-check-circle   pull-left" style="color:green"></i>';
            echo '<div style="Color:black">' . $Text . '</div>';
        } elseif ($get_Url == false) {
            $Text = Yii::t("miranda/seoanalizer", "the content does not have external links");
            echo '<i class="fa  fa-check-circle   pull-left" style="color:red"></i>';
            echo '<div style="Color:black">' . $Text . '</div>';
        }
        ?>



        <?php
        if ($countCaracter >= 40 and $countCaracter <= 70) {
            $Text = Yii::t("miranda/seoanalizer",
                "the title of the page contains more 40 characters and less than 70 characters is the limit recommended");
            echo '<i class="fa  fa-check-circle   pull-left" style="color:green"></i>';
            echo '<div style="Color:black">' . $Text . '</div>';
        } elseif ($countCaracter > 70) {
            $Text = Yii::t("miranda/seoanalizer",
                "the title of the page contains more than 70 characters the recommended limit");
            echo '<i class="fa  fa-check-circle   pull-left" style="color:red"></i>';
            echo '<div style="Color:black">' . $Text . '</div>';
        } elseif ($countCaracter < 40) {
            $Text = Yii::t("miranda/seoanalizer",
                "the title of the page contains less than 40 characters the recommended limit");
            echo '<i class="fa  fa-check-circle   pull-left" style="color:yellow"></i>';
            echo '<div style="Color:black">' . $Text . '</div>';
        }
        ?>



        <?php
        if (!empty($selectedTags)) {
            if ($checkContentInTag == true) {
                $Text = Yii::t("miranda/seoanalizer", "the tag keywords found in the content");
                echo '<i class="fa  fa-check-circle   pull-left" style="color:green"></i>';
                echo '<div style="Color:black">' . $Text . '</div>';
            } elseif ($checkContentInTag == false) {
                $Text = Yii::t("miranda/seoanalizer", "the key words of the tag are not in the content");
                echo '<i class="fa  fa-check-circle   pull-left" style="color:red"></i>';
                echo '<div style="Color:black">' . $Text . '</div>';
            }
        }
        ?>



        <?php
        if (!empty($selectedTags)) {
            if ($checkTitleInTags == true) {
                $Text = Yii::t("miranda/seoanalizer", "the title keywords found in the tag");
                echo '<i class="fa  fa-check-circle   pull-left" style="color:green"></i>';
                echo '<div style="Color:black">' . $Text . '</div>';
            } elseif ($checkTitleInTags == false) {
                $Text = Yii::t("miranda/seoanalizer", "the title keywords are not in the tag");
                echo '<i class="fa  fa-check-circle   pull-left" style="color:red"></i>';
                echo '<div style="Color:black">' . $Text . '</div>';
            }
        }
        ?>


    </div>
<?php endforeach; ?>