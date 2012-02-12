<?php
/**
 * @var StoreProduct $model
 */

$this->widget('application.modules.admin.widgets.schosen.SChosen', array(
    'elements'=>array()
));

?>

<style type="text/css">
    .variants h4 {
        padding-left: 5px;
    }
    .variantsTable thead tr td {
        padding: 5px;
    }
    .variantsTable tr td {
        padding: 3px;
    }
</style>

<script type="text/javascript">
    function cloneVariantRow(el)
    {
        var tableId = $(el).attr('rel');
        var baseRow = $(tableId + ' tbody tr')[0];
        $(baseRow).clone().removeClass('baseRow').show().appendTo($(tableId + ' tbody'));
        return false;
    }

    $(document).ready(function(){
        $("#addAttribute").click(function(){
            if($('#variantAttribute'+$('#variantAttribute').val()).length == 0)
            {
                $.ajax({
                    url: "renderVariantTable",
                    cache: false,
                    data: {attr_id: $('#variantAttribute').val()},
                    dataType: "html",
                    success: function(data){
                        $('#variantsData').append(data);
                    }
                });
            }
        });
    });
</script>

<div class="variants">
    <div class="row">
        <label>Добавить атрибут</label>
        <?php
            if($model->type)
	        {
                $attributes = $model->type->storeAttributes;
                echo CHtml::dropDownList('variantAttribute', null, CHtml::listData($attributes, 'id', 'title'));
            }
        ?>
        <a href="#" id="addAttribute">Добавить</a>
    </div>

    <hr>
    <div id="variantsData">
        <?php
            foreach($model->loadVariants() as $row)
            {
                $this->renderPartial('variants/_table', array(
                    'attribute'=>$row['attribute'],
                    'options'=>$row['options']
                ));
            }
        ?>
    </div>
</div>