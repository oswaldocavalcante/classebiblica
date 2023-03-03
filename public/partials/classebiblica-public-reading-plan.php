<?php

class Reading_Plan 
{
    public $bible = array ();  
    public $bibleReference = '';
    public $chapter = '';


	public function __construct() {
        $this->assemble_bible_structure();
        wp_enqueue_style('classebiblica-public-reading-plan', plugin_dir_url(__FILE__) . '../css/classebiblica-public-reading-plan.css');
        
		$starter_date = strtotime("2022/01/14");
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set("America/Maceio");
		$today = time();
		$daysCounter = ceil(($today - $starter_date) / 86400);

        $bibleReference = $this->get_bible_chapter_by_daysCounter($daysCounter);
        [$bookNumber, $chapterNumber] = $bibleReference;
        $bookIndex = $bookNumber - 1;

        $chapterContent = $this->get_db_bible_chapter($bookNumber, $chapterNumber);
        $htmlChapter = $this->get_chapter_html( $chapterContent );

        $book_key = array_keys($this->bible);
        $bookName = $this->bible[$book_key[$bookIndex]]['name'];
        
        $this->bibleReference = $bookName . ' ' . $chapterNumber;
        $this->chapter = $htmlChapter;
    }

    public function assemble_bible_structure () {
        $this->bible = array (
            'Gn' => array (
                'name' => 'Gênesis',
                'chapters' => 50
            ),
            'Ex' => array (
                'name' => 'Êxodo',
                'chapters' => 40
            ),
            'Lv' => array (
                'name' => 'Levítico',
                'chapters' => 27
            ),
            'Nm' => array (
                'name' => 'Números',
                'chapters' => 36
            ),
            'Dt' => array (
                'name' => 'Deuteronômio',
                'chapters' => 34
            ),
            'Js' => array (
                'name' => 'Josué',
                'chapters' => 24
            ),
            'Jz' => array (
                'name' => 'Juízes',
                'chapters' => 21
            ),
            'Rt' => array (
                'name' => 'Rute',
                'chapters' => 4
            ),
            '1Sm' => array (
                'name' => '1º Samuel',
                'chapters' => 31
            ),
            '2Sm' => array (
                'name' => '2º Samuel',
                'chapters' => 24
            ),
            '1Rs' => array (
                'name' => '1 Reis',
                'chapters' => 22
            ),
            '2Rs' => array (
                'name' => '2 Reis',
                'chapters' => 25
            ),
            '1Cr' => array (
                'name' => '1 Crônicas',
                'chapters' => 29
            ),
            '2Cr' => array (
                'name' => '2 Crônicas',
                'chapters' => 36
            ),
            'Ed' => array (
                'name' => 'Esdras',
                'chapters' => 10
            ),
            'Ne' => array (
                'name' => 'Neemias',
                'chapters' => 13
            ),
            'Et' => array (
                'name' => 'Ester',
                'chapters' => 10
            ),
            'Jó' => array (
                'name' => 'Jó',
                'chapters' => 42
            ),
            'Sl' => array (
                'name' => 'Salmos',
                'chapters' => 150
            ),
            'Pv' => array (
                'name' => 'Provérbios',
                'chapters' => 31
            ),
            'Ec' => array (
                'name' => 'Eclesiastes',
                'chapters' => 12
            ),
            'Ct' => array (
                'name' => 'Cânticos',
                'chapters' => 8
            ),
            'Is' => array (
                'name' => 'Isaías',
                'chapters' => 66
            ),
            'Jr' => array (
                'name' => 'Jeremias',
                'chapters' => 52
            ),
            'Lm' => array (
                'name' => 'Lamentações',
                'chapters' => 5
            ),
            'Ez' => array (
                'name' => 'Ezequiel',
                'chapters' => 48
            ),
            'Dn' => array (
                'name' => 'Daniel',
                'chapters' => 12
            ),
            'Os' => array (
                'name' => 'Oséias',
                'chapters' => 14
            ),
            'Jl' => array (
                'name' => 'Joel',
                'chapters' => 3
            ),
            'Am' => array (
                'name' => 'Amós',
                'chapters' => 9
            ),
            'Ob' => array (
                'name' => 'Obadias',
                'chapters' => 1
            ),
            'Jn' => array (
                'name' => 'Jonas',
                'chapters' => 4
            ),
            'Mq' => array (
                'name' => 'Miquéias',
                'chapters' => 7
            ),
            'Na' => array (
                'name' => 'Naum',
                'chapters' => 3
            ),
            'Hc' => array (
                'name' => 'Habacuque',
                'chapters' => 3
            ),
            'Sf' => array (
                'name' => 'Sofonias',
                'chapters' => 3
            ),
            'Ag' => array (
                'name' => 'Ageu',
                'chapters' => 2
            ),
            'Zc' => array (
                'name' => 'Zacarias',
                'chapters' => 14
            ),
            'Ml' => array (
                'name' => 'Malaquias',
                'chapters' => 4
            ),
            'Mt' => array (
                'name' => 'Mateus',
                'chapters' => 28
            ),
            'Mc' => array (
                'name' => 'Marcos',
                'chapters' => 16
            ),
            'Lc' => array (
                'name' => 'Lucas',
                'chapters' => 24
            ),
            'Jo' => array (
                'name' => 'João',
                'chapters' => 21
            ),
            'At' => array (
                'name' => 'Atos',
                'chapters' => 28
            ),
            'Rm' => array (
                'name' => 'Romanos',
                'chapters' => 16
            ),
            '1Co' => array (
                'name' => '1 Coríntios',
                'chapters' => 16
            ),
            '2Co' => array (
                'name' => '2 Coríntios',
                'chapters' => 13
            ),
            'Gl' => array (
                'name' => 'Gálatas',
                'chapters' => 6
            ),
            'Ef' => array (
                'name' => 'Efésios',
                'chapters' => 6
            ),
            'Fp' => array (
                'name' => 'Filipenses',
                'chapters' => 4
            ),
            'Cl' => array (
                'name' => 'Colossenses',
                'chapters' => 4
            ),
            '1Ts' => array (
                'name' => '1 Tessalonicenses',
                'chapters' => 5
            ),
            '1Ts' => array (
                'name' => '2 Tessalonicenses',
                'chapters' => 3
            ),
            '1Tm' => array (
                'name' => '1 Timóteo',
                'chapters' => 6
            ),
            '2Tm' => array (
                'name' => '2 Timóteo',
                'chapters' => 4
            ),
            'Tt' => array (
                'name' => 'Tito',
                'chapters' => 3
            ),
            'Fm' => array (
                'name' => 'Filemon',
                'chapters' => 1
            ),
            'Hb' => array (
                'name' => 'Hebreus',
                'chapters' => 13
            ),
            'Tg' => array (
                'name' => 'Tiago',
                'chapters' => 5
            ),
            '1Pe' => array (
                'name' => '1 Pedro',
                'chapters' => 5
            ),
            '2Pe' => array (
                'name' => '2 Pedro',
                'chapters' => 3
            ),
            '1Jo' => array (
                'name' => '1 João',
                'chapters' => 5
            ),
            '2Jo' => array (
                'name' => '2 João',
                'chapters' => 1
            ),
            '3Jo' => array (
                'name' => '3 João',
                'chapters' => 1
            ),
            'Jd' => array (
                'name' => 'Judas',
                'chapters' => 1
            ),
            'Ap' => array (
                'name' => 'Apocalipse',
                'chapters' => 22
            )
        );
    }

    public function get_chapter_html( $chapterContent ){
        $verses = '';
        $verseNumber = 0;

        foreach($chapterContent as $verse) {
            $verseNumber ++;
            $verses .= '<div class="cb_rp_verse"><span class="cb_rp_verse_number">' . $verseNumber . '</span><span class="cb_rp_verse_text">' . $verse->pt_nar . '</span></div>';
        }

        return $verses;
    }


	public function get_bible_chapter_by_daysCounter( $daysCounter ) {
        if( $daysCounter > 1189 ) return; //If is greater than the total chapters of the Bible

        $reference = array();
        $bookIndex = 0;

        foreach ($this->bible as $book){
            $bookIndex ++;
            if ( $daysCounter > $book['chapters'] ) {
                $daysCounter -= $book['chapters'];
                continue;
            }
            if ( $daysCounter <= $book['chapters'] ) {
                $chapter = $daysCounter;
                $reference = array ( $bookIndex, $chapter );
                break;
            }
        }

        return $reference;
	}

	public function get_db_bible_chapter( $bookNumber, $chapterNumber ){
		global $wpdb;

		$chapterContent = $wpdb->get_results(
			$wpdb->prepare(
                "SELECT pt_nar
                FROM {$wpdb->prefix}biblia_nar
                WHERE book_id = %d
                AND chapter = %d
            ",
                $bookNumber,
                $chapterNumber
            )
		);

		return $chapterContent;
	}

    public function render() {
        return '
            <div class="cb_rp_container">
                <div class="cb_rp_date">' . esc_attr(strftime('%A, %d de %B de %Y', strtotime('today'))) . '</div>
                <div class="cb_rp_bible_reference_container">
                    <span class="cb_rp_bible_reference_title">Capítulo de hoje: </span>
                    <span class="cb_rp_bible_reference">' . $this->bibleReference . '</span></div>
                <div class="cb_rp_bible_chapter">' . $this->chapter . '</div>
            </div>
        ';
    }
}