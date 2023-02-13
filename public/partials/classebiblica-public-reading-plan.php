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
                'name' => '1º Reis',
                'chapters' => 22
            ),
            '2Rs' => array (
                'name' => '2º Reis',
                'chapters' => 25
            ),
            '1Cr' => array (
                'name' => '1º Crônicas',
                'chapters' => 29
            ),
            '2Cr' => array (
                'name' => '2º Crônicas',
                'chapters' => 36
            ),
            'Ed' => array (
                'name' => 'Esdras',
                'chapters' => 10
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
            ),
            'Ab' => array (
                'name' => 'Nome',
                'chapters' => 99
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
                <div class="cb_rp_date">' . strftime('%A, %d de %B de %Y', strtotime('today')) . '</div>
                <div class="cb_rp_bible_reference_container">
                    <span class="cb_rp_bible_reference_title">Capítulo de hoje: </span>
                    <span class="cb_rp_bible_reference">' . $this->bibleReference . '</span></div>
                <div class="cb_rp_bible_chapter">' . $this->chapter . '</div>
            </div>
        ';
    }
}