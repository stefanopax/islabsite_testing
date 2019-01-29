<?php

use yii\db\Migration;

/**
 * Class m181204_154704_create_page
 */
class m181204_154704_create_page extends Migration
{
    public function up()
    {
        $this->createTable('page', [
            'id' => $this->primaryKey(),
            'title' => $this->string(30)->notNull(),
            'content' => $this->text(),
            'is_home' => $this->boolean(),
            'is_public' => $this->boolean(),
            'is_news' => $this->boolean(),
            'course_site' => $this->integer()->notNull()

        ]);

        $this->createIndex('idx-page-id','page','id');
        $this->addForeignKey('fk-page-course_site','page','course_site','course_site','id','CASCADE','CASCADE');

        /* query to get course site ids */
        $id1 = (new \yii\db\Query())->select(['id'])->from('course_site')->where(['title' => 'Basi di dati', 'edition' => '2018/2019']);
        $id2 = (new \yii\db\Query())->select(['id'])->from('course_site')->where(['title' => 'Sistemi informativi', 'edition' => '2018/2019']);

        /* trial html to fill the page */
        $db_home = '
                    Il corso si propone di fornire i concetti e le metodologie fondamentali relativamente alle basi di dati e ai sistemi per la loro gestione, con particolare riguardo ai sistemi di basi di dati relazionali.<br></br>
                    È prevista una parte di laboratorio dedicata all\'acquisizione e uso dei principali strumenti di gestione e progettazione di basi di dati relazionali e una parte dedicata alle principali tecnologie di basi di dati e Web.
                    <br></br>
                    Il corso si svolge nel primo semestre.
                    <h2 style="color: orange">Orari e luogo delle lezioni</h2>
                    Lunedì 15.30-18.30 aula V3, Via Venezian 15<br></br>
                    Martedì 15.30-18.30 aula G21, Via Golgi 19<br></br>
                    Giovedì 14.30-18.30 - lezione di laboratorio, aule Sigma e Tau, via Comelico, 39<br></br>
                    <br></br>
                    <b>Le lezioni di laboratorio hanno inizio alle ore 15</b> e si svolgono in parallelo nelle aule Sigma e Tau. Per questioni organizzative, si tenga presente la seguente suddivisione indicativa degli studenti nelle due aule:<br></br>
                    <b>aula Sigma: studenti A-L<br></br></b>
                    <b>aula Tau: studenti M-Z<br></br></b>
                    <h2 style="color: orange">Orario di ricevimento</h2>
                    <b style="color:orange">Alfio Ferrara</b><br></br>
                    Venerdì 11.30-13.30 - stanza 7012 (7 piano)<br></br>
                    <b style="color:orange">Stefano Montanelli</b> (laboratorio e gestione progetti)<br></br>
                    Giovedì 11-12 - stanza 7015 (7 piano)<br></br>
                    <b style="color:orange">Marco Frasca</b> (laboratorio e gestione progetti)<br></br>
                    Martedì 15-16 - stanza 3021 (3 piano)<br></br>
                    Le eventuali modifiche all\'orario di ricevimento saranno pubblicate su questo sito.<br></br>
                    Vedere le comunicazioni nelle ultime notizie (in alto a destra della pagina).<br></br>
                    ';
        $db_project = '
                        <p>
                            La traccia del progetto per l\'Anno Accademico 2018-19 è disponibile nella sezione del materiale didattico (è necessaria la registrazione al corso per accedere) e sarà valida per la consegna negli appelli da gennaio 2019 a gennaio 2020 inclusi.
                        </p>
                        <h2 style="color: orange">Modalità di consegna</h2>
                        È possibile consegnare il progetto ad ogni appello d\'esame, entro il giorno previsto per l\'appello stesso. Di norma, la procedura di consegna è aperta dall\'inizio del mese in cui si svolge l\'appello (circa 2-3 settimane prima del giorno dell\'appello).
                        La consegna prevede due passaggi (entrambi obbligatori per partecipare alla correzione):<br></br>
                        <ul class="uk-list uk-list-bullet">
                            <li>Consegna in forma elettronica mediante i seguenti passaggi:</li>
                            Produrre un archivio compresso contenente tutto il materiale del progetto. Si noti che solo i formati ZIP, RAR, TAR, GZ e TGZ sono ammessi.
                            Denominare l\'archivio come segue: BDLAB_matricola_nomecognome. Se il progetto è presentato in gruppo è necessario denominare il file con i dati dello studente con il primo cognome in ordine alfabetico.
                            Accedere al sito del corso mediante il pulsante di login (in alto a sinistra) e le credenziali di ateneo.
                            Nel menù sulla destra, selezionare la voce "Esami" e "Nuove iscrizioni", quindi scegliere l\'appello nel quale si intende presentare e discutere il progetto.
                            Caricare l\'archivio contenente il materiale per perfezionare l\'iscrizione. Nota per i gruppi: Il caricamento dell\'archivio deve essere effettuato dallo studente con il primo cognome in ordine alfabetico. L\'altro membro del gruppo deve comunque iscriversi all\'appello accedendo al sito del corso mediante le proprie credenziali di ateneo. Dopo aver selezionato la voce "Esami" e "Nuove iscrizioni" nel menù sulla destra, sarà necessario utilizzare la funzionalità "aggiungiti ad un gruppo già esistente" e inserire la matricola del compagno che ha precedentemente caricato l\'archivio contenente il materiale del progetto.
                            <li>Consegna in forma cartacea mediante una delle seguenti modalità (vedere le modalità di consegna allegate alla traccia del progetto per sapere cosa è necessario consegnare in forma cartacea):</li>
                            Consegna in forma cartacea mediante una delle seguenti modalità (vedere le modalità di consegna allegate alla traccia del progetto per sapere cosa è necessario consegnare in forma cartacea):
                            Consegna durante l\'appello dei presenti all\'inizio della prova d\'esame scritta.
                            Consegna durante l’orario di ricevimento di uno dei responsabili del laboratorio (Prof. Frasca e Prof. Montanelli). Si veda la home page del sito del corso per date e orari degli orari di ricevimento.
                            Nei giorni successivi ad ogni appello, nelle ultime notizie sul sito del corso, sarà pubblicato un calendario di discussione dei progetti consegnati. Di norma la correzione avviene entro due settimane dalla data dell\'appello.
                        </ul>
                    ';
        $db_material = '
                    <h3 class="uk-text-center">Hai l\'accesso per visualizzare la pagina</h3>
                ';
        $db_program = '
                        I temi trattati nel corso sono:
                        <ul class="uk-list uk-list-bullet">
                            <li>Concetti e architettura di un sistema di basi di dati</li>
                            <li>Modello relazionale, vincoli, normalizzazione</li>
                            <li>Modellazione dei dati, modello ER e nozioni di progettazione</li>
                            <li>Progettazione logica</li>
                            <li>Algebra relazionale</li>
                            <li>SQL</li>
                            <li>Organizzazione fisica dei dati e indici</li>
                            <li>Sicurezza e controllo dell\'accesso</li>
                            <li>Transazioni (concetti generali)</li>
                        </ul>
                        <ul class="uk-list uk-list-bullet">
                            I temi trattati nel laboratorio sono:
                            <li>Il DBMS PostgreSQL</li>
                            Creazione e manipolazione di schemi
                            Gestione di utenti e ruoli
                            Firewall degli accessi (hba.conf)
                            Dump di basi di dati
                            Linguaggio procedurale (PLpgSQL)
                            <li>Programmazione web con PHP</li>
                            Architettura client/server
                            Protocollo HTTP
                            Passaggio di parametri GET/POST
                            Cookie/sessioni
                            Interazione con i DBMS
                            Esercitazioni
                        </ul>
                        È inoltre disponibile il programma dettagliato.
    
                        <li>G. Bracchi, C. Francalanci, G. Motta
                            <br></br>
                            <i>Sistemi Informativi d’impresa</i>
                            McGraw-Hill, 2010.
                        </li>
                        <li>M. Golfarelli, S. Rizzi.
                            <br></br>
                            <i>Data Warehouse - Teoria e pratica della progettazione (2 ed.)</i>
                            McGraw-Hill, 2006.
                        </li>
                        <li>Materiale didattico integrativo disponibile sul sito web del corso
                        </li>
                        </ul>
                        <h2 style="color: orange">Bibliografia del corso</h2>
                        Il corso è costruito a partire da due testi di riferimento:
                        R. Elmasri, S.B. Navathe
                        Sistemi di basi di dati - Fondamenti (6 ed.)
                        edizione italiana a cura di Silvana Castano
                        Pearson-Addison Wesley, 2011.
                        <br></br>
                        P.Atzeni, S. Ceri, S. Paraboschi, R. Torlone
                        Basi di dati - Modelli e linguaggi di interrogazione (2 ed.)
                        McGraw-Hill, 2006.
                        <br></br>
                        Sono inoltre disponibili altri materiali didattici, dispense e contenuti di laboratorio (previa iscrizione al corso tramite il sito).
                        <br></br>
                        <b>Altri testi utili:</b><br></br>
                        S. Castano, M. Fugini, G. Martella, P. Samarati
                        Database Security
                        Addison-Wesley, 1995.
                        <h2 style="color: orange">Bibliografia del laboatorio</h2>
                        Gli strumenti impiegati nel laboratorio sono PostgreSQL e PHP.
                        I manuali ufficiali degli strumenti (consultabili online) sono una risorsa importante e utile. Ulteriori fonti per la risoluzione di problematiche specifiche possono essere reperite via web tramite motore di ricerca. Coloro che intendono approfondire i temi del laboratorio e l\'uso dei relativi strumenti possono fare riferimento ai testi consigliati.
                        <br></br>
                        Materiale online:
                        PostgreSQL - manuale ufficiale
                        PHP - manuale ufficiale
                        <br></br>
                        Testi consigliati:
                        H.Krosing, J. Mlodgenski, K. Roybal
                        PostgreSQL: Programmazione Avanzata
                        Apogeo, 2013.
                        <br></br>
                        Regina Obe, Leo Hsu
                        PostgreSQL: Up and Running
                        O\'Reilly, 2012.
                        <br></br>
                        L. Ullman
                        PHP for the Web (4th Edition)
                        Peachpit Press, 2011.
                        <br></br>
                        A. Gutmans, S. Bakken, D. Rethans
                        PHP 5 - Guida Completa
                        Apogeo, 2005.';
        $db_news = '
                <h4>Ultime notizie	RSS feed</h4>
                <b>Progetti di laboratorio - consegna materiale cartaceo</b>
                <br>
                A partire dall’appello di settembre 2018, la consegna del materiale cartaceo del progetto di laboratorio deve avvenire con una delle seguenti modalità:
                <ul>
                    <li>
                        consegna brevi manu a uno dei responsabili del laboratorio (Marco Frasca o Stefano Montanelli) durante l’orario di ricevimento (si veda la home page del sito del corso per date e orari)
                    </li>
                    <li>
                        consegna a uno dei docenti presenti durante l’appello dei presenti all’inizio dell\'esame scritto
                    </li>
                </ul>
                <b>Registrazione al corso - importante</b>
                <br>
                Quando si effettua la registrazione al corso, è importante inserire anche il proprio numero di matricola.
                Coloro che sono si sono registrati senza indicare il numero di matricola, possono accedere al sito con le credenziali di ateneo e seguire il link sulla destra modifica e il tuo profilo.
    
                Gli avvisi sui siti Web si intendono aggiornati e gli studenti sono vivamente pregati di NON INVIARE email con richieste di conferma di date/orari.
                Precedente edizione del corso
                Le informazioni relative al corso dell\'A.A. 2017-18 sono disponibili in archivio
        ';
        $si_home = '
                        Il corso ha come obiettivo l\'acquisizione delle conoscenze di base dei Sistemi Informativi aziendali, con riferimento a modelli e architetture dei processi nei sistemi di front-end (e.g., Customer Relationship Management system- CRM), di back-end (e.g., Enterprise Resource Planning systems -ERP) e nei sistemi di governance (e.g., Business Intelligence- BI). Il corso approfondisce in particolare gli aspetti metodologici relativi all\'analisi e progettazione di datawarehouse. Sono infine discussi nuovi requisiti e opportunità derivanti dai big data.<br />
                        Il corso si svolge nel primo semestre.
                        <h2 style="color: orange">Orari e luogo delle lezioni</h2>
                            Luned&igrave; 13.30-17.30 aula magna "Alberto Bertoni", via Celoria, 18
                        <h2 style="color: orange">Orario di ricevimento</h2>
                        <a href="mailto:silvana.castano@unimi.it" style="color: orange"><b>Prof.ssa Silvana Castano</b></a>
                        <br></br>
                        Su appuntamento via email
                    ';
        $si_material = '
                    <h3 class="uk-text-center">Hai l\'accesso per visualizzare la pagina</h3>
        ';
        $si_program = '
                        <p>
                            Il programma d\'esame è disponibile per il download:
                        </p>
                        <p>
                            <a href="http://islab.di.unimi.it/?option=com_islabteachpages&view=download&fileid=222">programma dettagliato</a>
                        </p>
                        <h2 style="color: orange">Testi di riferimento</h2>
                        <ul class="uk-list uk-list-bullet">
                            <li>
                                G. Bracchi, C. Francalanci, G. Motta
                                <br></br>
                                <i>Sistemi Informativi d’impresa</i>
                                McGraw-Hill, 2010.
                            </li>
                            <li>
                                M. Golfarelli, S. Rizzi.
                                <br></br>
                                <i>Data Warehouse - Teoria e pratica della progettazione (2 ed.)</i>
                                McGraw-Hill, 2006.
                            </li>
                            <li>
                                Materiale didattico integrativo disponibile sul sito web del corso
                            </li>
                        </ul>
                    ';
        $si_news = '
                <h4>Ultime notizie	RSS feed</h4>
                <b>Progetti di laboratorio - consegna materiale cartaceo</b>
                <br>
                A partire dall’appello di settembre 2018, la consegna del materiale cartaceo del progetto di laboratorio deve avvenire con una delle seguenti modalità:
                <ul>
                    <li>
                        consegna brevi manu a uno dei responsabili del laboratorio (Marco Frasca o Stefano Montanelli) durante l’orario di ricevimento (si veda la home page del sito del corso per date e orari)
                    </li>
                    <li>
                        consegna a uno dei docenti presenti durante l’appello dei presenti all’inizio dell\'esame scritto
                    </li>
                </ul>
                <b>Registrazione al corso - importante</b>
                <br>
                Quando si effettua la registrazione al corso, è importante inserire anche il proprio numero di matricola.
                Coloro che sono si sono registrati senza indicare il numero di matricola, possono accedere al sito con le credenziali di ateneo e seguire il link sulla destra modifica e il tuo profilo.
    
                Gli avvisi sui siti Web si intendono aggiornati e gli studenti sono vivamente pregati di NON INVIARE email con richieste di conferma di date/orari.
                Precedente edizione del corso
                Le informazioni relative al corso dell\'A.A. 2017-18 sono disponibili in archivio
           ';

        /* insert for testing */
        $this->batchInsert('page', ['title', 'content', 'is_home', 'is_public', 'is_news', 'course_site'], [
            ['Home', $db_home, true, true, false, $id1],
            ['Progetto', $db_project, false, false, false, $id1],
            ['Materiale didattico', $db_material, false, false, false, $id1],
            ['Programma', $db_program, false, true, false, $id1],
            ['News', $db_news, false, true, true, $id1 ],
            ['Home', $si_home , true, true, false, $id2],
            ['Materiale didattico', $si_material, false, false, false, $id2],
            ['Programma', $si_program, false, true, false, $id2],
            ['News', $si_news, false, true, true, $id2]
        ]);
    }

    public function down()
    {
        $this->dropForeignKey('fk-page-course_site','page');
        $this->dropIndex('idx-page-id','page');

        $this->delete('page');
        $this->dropTable('page');
    }
}
