<?php

// this could be useful in case of export failing

/*$exporter = new Spreadsheet([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => [
            [
                'name' => 'some name',
                'price' => '9879',
            ],
            [
                'name' => 'name 2',
                'price' => '79',
            ],
        ],
    ]),
    'columns' => [
        [
            'attribute' => 'name',
            'contentOptions' => [
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center',
                ],
            ],
        ],
        [
            'attribute' => 'price',
        ],
    ],
]);
$exporter->save('/path/to/file.xls');*/
?> 