<?php

use yii\db\Migration;

/**
 * Class m181025_134527_create_project
 */
class m181025_134527_create_project extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('project', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull(),
            'description' => $this->text()->notNull(),
            'link' => $this->string(100)->notNull(),
            'created_at' => $this->integer(),
            'image' => $this->string(100)->notNull(),
            'is_deleted' => $this->boolean()->defaultValue('false')
        ]);

        /* insert for testing*/
        $this->batchInsert('project', ['title', 'description', 'link', 'created_at', 'image', 'is_deleted'], [
            ['LiquidCrow', 'A Consensus-based Crowdsourcing Framework','http://islab.di.unimi.it/LiquidCrowd/', Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),'/img/lclogo.png',false],
            ['inWalk', 'Interactive and Thematic Walks inside the Web of Data','http://islab.di.unimi.it/inWalkProject/', Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),'/img/iwlogo.png',false],
            ['Mi-Search', 'Aggregazione semantica di contenuti web per costruire la tua città della cultura e del divertimento','http://islab.di.unimi.it/misearch/', Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),'/img/misearch-logo.jpg',false],
            ['HMatch', 'The ISLab Ontology Matching System','http://islab.di.unimi.it/hmatch/', Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),'/img/hmlogo.jpg',false],
            ['iCoord', 'The ISLab Knowledge Coordination Platform','http://islab.di.unimi.it/icoord/iCoord/Home.html', Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')), '/img/icoord.jpg',false],
            ['Euro-Inf Spread','Dissemination and Exploitation of a European System of Informatics Accreditation EU LLP Project n. 505327-LLP-1-DEKA4-KA4MP, 2009 - 2011','http://www.eqanie.eu/pages/euro-inf-spread-project.php', Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),'/img/euroinf.jpg',false],
            ['Boemie','Bootstrapping Ontology Evolution with Multimedia Information Extraction Project n. FP6-027538, 2006 - 2009','http://www.eqanie.eu/pages/euro-inf-spread-project.php', Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),'/img/boemie.jpg',false],
            ['Interop Network of Excellence','Interoperability Research for Networked Enterprises Applications and Software IST Project n. 508011, 2003 - 2006','http://interop-vlab.eu/', Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),'/img/interop.jpg',false],
            ['InterOP-VLab.it','Italian Pole of the European Virtual Laboratory for Interoperability of Enterprise and Business','http://interop-vlab.eu/', Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),'/img/interop-vlab.jpg',false],
            ['Wide-scalE, Broadband, MIddleware for Network Distributed Services', 'FIRB project N.RBNE01WEJT_005, MIUR (Italian Ministry of Education, University, and Research). 2002 - 2005', 'https://www.consorzio-cini.it/index.php/it/?q=node/54', Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),'/img/webminds.gif',false],
            ['Helios','Helios Evolving Interaction-based Ontology knowledge Sharing', 'http://islab.di.unimi.it/prj/helios/', Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),'/img/hel.gif',false],
            ['D2I', 'Integration, Warehousing, and Mining of Heterogeneous Data Source. COFIN project funded by the Italian Ministry of Education, University, and Research. 2000 - 2002', 'http://www.dis.uniroma1.it/~lembo/D2I/', Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')), '/img/d2i.jpg',false],
            ['Artemis', 'Analysis and Reconciliation Tool Environment for Multiple Information Sources','http://islab.di.unimi.it/prj/artemis/', Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),'/img/art.gif',false]
        ]);
    }

    public function down()
    {
        $this->delete('project');
		$this->	dropTable('project');
    }
}
