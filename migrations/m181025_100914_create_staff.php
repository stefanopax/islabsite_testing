<?php

use yii\db\Migration;

/**
 * Class m181025_100914_create_staff
 */
class m181025_100914_create_staff extends Migration
{
    /**
     * {@inheritdoc}
     * @throws Exception
     */
   public function up()
    {
        $this->createTable('staff', [
            'id' => $this->primaryKey(),
            'cellphone' => $this->string(20),
            'phone' => $this->string(20),
			'mail' => $this->string(100),
            'room' => $this->string(100),
            'address' => $this->string(100),
            'image' => $this->string(100)->notNull(),
            'fax' => $this->string(20),
            'role' => $this->string(100),
            'description' => $this->text(),
            'link' => $this->string(100)
        ]);

        $this->createIndex('idx-staff-id','staff','id');
        $this->addForeignKey('fk-staff-user','staff','id','user','id','CASCADE','CASCADE');

        /* query to get user ids */
		$id1 = (new \yii\db\Query())->select(['id'])->from('user')->where(['username' => 'silvana.castano@unimi.it']);
        $id2 = (new \yii\db\Query())->select(['id'])->from('user')->where(['username' => 'alfio.ferrara@unimi.it']);
        $id3 = (new \yii\db\Query())->select(['id'])->from('user')->where(['username' => 'stefano.montanelli@unimi.it']);
        $id4 = (new \yii\db\Query())->select(['id'])->from('user')->where(['username' => 'marco.frasca@unimi.it']);

        /* insert for testing */
        $this->batchInsert('staff', ['id', 'cellphone', 'phone', 'mail', 'room', 'address', 'image', 'fax', 'role', 'description', 'link'], [
            [$id1,NULL,'+390250316379','castano@di.unimi.it',NULL, 'Via Celoria 18, 20133 Milano','/img/castano.png','+390250316229','Full Professor, ISLab Chair','Silvana Castano is full professor of database and information systems at the University of Milano, where she currently chairs the Information systems & knowledge management (ISLab) group of the Dipartimento di Informatica. She received the Ph.D. degree in Computer Engineering from Politecnico di Milano. Her main research interests are in the area of databases and information systems and ontologies and Semantic Web, with current focus on knowledge discovery and sharing in peer-based systems, ontology matching and evolution, semantic knowledge coordination, emergent semantics in open networked systems, data integration, and semantic interoperability. She has published her research results in more than 100 papers in the major journals and in the refereed proceedings of the major conferences of the field. On these topics, she has been working in several national and international research projects, acting as local coordinator of the UNIMI unit in the european projects FP7 EQANIE EURO-INF SPREAD, FP6 BOEMIE (Bootstrapping Ontology Evolution with Multimedia Information Extraction), FP6 INTEROP-NoE (Interoperability Research for Networked Enterprises Applications and Software) and the national projects PRIN ESTEEM on semantic communities, D2I on data integration, FIRB WEB-MINDS on advanced middleware for networked services. She is founding member of INTEROP-VLab.it, the italian pole of the International Virtual Laboratory for Enterprise Interoperability stemming from the INTEROP project.
            Silvana Castano has been serving as PC member for several important database, information systems, and Semantic Web conferences, regularly she is PC member of ER, CAiSE, DEXA, RCIS. She is member of the Steering Committee of the International Conference on Conceptual Modeling (ER). She is PC co-chair of the ER 2009 conference and PC-chair of SEBD 2009. She is workshop co-chair of ER 2012. She was President-Elected of GRIN - Gruppo di Informatica, the Italian association of University Professors in Informatics in the period 2008-2014.','/staff/view?id=1'],
            [$id2, NULL, '+390250316379','alfio.ferrara@unimi.it', NULL, 'Via Celoria 18, 20133 Milano', '/img/alfio_ferrara.jpg', '+390250316219' , 'Associate Professor','Alfio Ferrara is associate professor of Computer Science at the University of Milano, where he received his Ph.D. in Computer Science in 2005. His research interests include database and semi-structured data integration, data linking, Web-based information systems, data analysis, and knowledge representation and evolution. On these topics, he worked in national and international research projects, including EU FP6 BOEMIE, the FP6 INTEROP NoE, and the ESTEEM (Emergent Semantics and cooperaTion in multi-knowledgE EnvironMents) PRIN project funded by the Italian Ministry of Education, University, and Research, and the EVA Project funded by the Italian Agency for the Evaluation of Research and Universities. He is also author of more than 80 contributions as papers in international conferences and journals, and chapters in international books. He served as program committee member of various international conferences and he is a founder and part of the board of the instance matching track at the Ontology Alignment Evaluation Initiative (OAEI).','/staff/view?id=2'],
            [$id3, NULL, '+390250316283','stefano.montanelli@unimi.it', NULL, 'Via Celoria 18, 20133 Milano','/img/profile.jpg','+390250316373', 'Assistant Professor', 'Stefano Montanelli is Assistant Professor at the Department of Computer Science, University of Milano (UNIMI), where he received his Ph.D. in Informatics in 2007. His main research interests include web-based information systems, semantic web, data matching, emergent semantics in open distributed systems, web data classification and summarization, crowd phenomena, and city data management. On these topics, he published articles and papers in international and national journals and conferences.
            He participated with the UNIMI-ISLab group to national and international research projects, including EU FP6 BOEMIE (Bootstrapping Ontology Evolution with Multimedia Information Extraction), EU FP6 INTEROP NoE (Interoperability Research for Networked Enterprises Applications and Software), and MIUR-PRIN2005 ESTEEM (Emergent Semantics and Cooperation in Multi-knowledge Environments). He participated to a project line about urban information integration in collaboration with Fastweb SpA within the Dote Ricerca funded by Regione Lombardia. He is co-author of the book Informazione, conoscenza e Web per le scienze umanistiche, Pearson-Addison Wesley.','/staff/view?id=3'],
            [$id4, NULL, NULL, 'marco.frasca@unimi.it', NULL, 'Via Celoria 18, 20133 Milano','/img/islab.png', NULL, NULL, NULL,'/staff/view?id=4'],
        ]);

        /* rbac assignments */
        $id1 = (new \yii\db\Query())->select(['id'])->from('user')->where(['username' => 'silvana.castano@unimi.it']);
        $id2 = (new \yii\db\Query())->select(['id'])->from('user')->where(['username' => 'alfio.ferrara@unimi.it']);
        $id3 = (new \yii\db\Query())->select(['id'])->from('user')->where(['username' => 'stefano.montanelli@unimi.it']);
        $id4 = (new \yii\db\Query())->select(['id'])->from('user')->where(['username' => 'marco.frasca@unimi.it']);

        $auth = \Yii::$app->authManager;
        $authRole = $auth->getRole('staff');
        $auth->revokeAll($id1);
        $auth->revokeAll($id2);
        if($authRole) {
            $auth->assign($authRole, $id1);
            $auth->assign($authRole, $id2);
        }

        $authRole = $auth->getRole('admin');
        $auth->revokeAll($id3);
        if($authRole) {
            $auth->assign($authRole, $id3);
        }

        $authRole = $auth->getRole('teacher');
        $auth->revokeAll($id4);
        if($authRole) {
            $auth->assign($authRole, $id4);
        }
    }

    public function down()
    {
        $this->dropForeignKey('fk-staff-user','staff');
        $this->dropIndex('idx-staff-id','staff');

        $this->delete('staff');
        $this->dropTable('staff');
    }
}
