<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use app\models\Category;
use app\models\Location;
use yii\helpers\Html;

/**
 * Выводит панель продвинутого поиска для определенной категории
 *
 * @author Max Uglov <vencendor@mail.ru>
 *
 *
 */
class advancedSearch extends Widget
{

    public function run()
    {

        $cat_id = Yii::$app->request->getBodyParam('cat_id');

        if (isset(Yii::$app->params['categories'][intval($cat_id)])) {
            $curent_cat = Yii::$app->params['categories'][$cat_id];
        } else {
            $curent_cat = false;
        }


        //echo "<form action='" . Url::to("adverts/search") . "'>";
        // Проверка есть ли дочерние 
        if ($curent_cat['lft'] + 1 != $curent_cat['rgt'] or $curent_cat === false) {
            if ($curent_cat) {
                $subcat = Yii::$app->db->createCommand('select id,name  from category  '
                    . 'where root=' . $curent_cat['root'] . ' and lft>' . $curent_cat['lft'] . ' '
                    . 'and rgt<' . $curent_cat['rgt'] . ' and level=' . ($curent_cat['level'] + 1) . ' ')->query();
            } else {
                $subcat = Category::roots();
            }
            if ($subcat) {
                ?>
                <label for='cat_id'> Подкатегория </label> <select name='cat_id'>
                    <option value='<?= $cat_id ?>'>  ---  </option>
                    <?php                     foreach ($subcat as $scat) {
                        echo "<option value='" . $scat['id'] . "' " . ($scat['id'] == Yii::$app->request->getBodyParam("cat_id") ? "selected='selected'" : "") . ">" . $scat['name'] . "</option>";
                    }
                    ?>
                </select> <br/>
            <?php             }
        } else {
            echo "<input type='hidden' name='cat_id' value='$cat_id' />";
        }
        if (is_array($curent_cat['fields'])) {
            foreach ($curent_cat['fields'] as $f_id => $field) {
                if ($field['type'] === "1") {
                    echo "<input type='checkbox' name='fields[$f_id]' /> " . $field['name'] . "<br/>";
                } elseif ($field['type'] === "2") {
                    echo $field['name'] . "<select name='fields[$f_id]'> ";
                    echo "<option value=''></option>";
                    foreach ($field['atr'] as $a_n => $atr) {
                        echo "<option value='$a_n'>$atr</option>";
                    }
                    echo "</select>";
                }
            }
        }

        $price_min = Yii::$app->request->getBodyParam("Adverts");
        $price_min = $price_min["price_min"];
        $price_max = Yii::$app->request->getBodyParam("Adverts");
        $price_max = $price_min["price_max"];


        echo "<label for='Adverts[price_min]'>Цена от</label><input type='text' name='Adverts[price_min]' value='" . $price_min . "' />";
        echo "<label for='Adverts[price_max]' class='sh'>до</label><input type='text' name='Adverts[price_max]' value='" . $price_max . "' /><br/>";

        $loc = Location::geoDetect();
        echo "<label for='locationName'>" . t("Location") . "</label>";
        ?>
        <script>
            $(window).load(function () {
                $("#form_locationName").autocomplete({
                    source: baseUrl + "/site/location_list",
                    minLength: 2,
                    select: function (event, ui) {
                        $("#form_location").val(ui.item.id);
                    }
                });
            });
        </script>
        <?php echo Html::textInput('form_locationName', $_POST['form_locationName'] ?: $loc['name']);
        echo Html::hiddenInput('form_location', $loc['id']);
    }

}
