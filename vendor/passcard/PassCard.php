<?php

/**
 *
 */
class PassCard {

    private $charList;
    private $matrixWidth;
    private $matrixHeight;
    private $diagonalEscape;
    private $horizontalEscape;
    private $verticalEscape;
    private $colChar;
    private $rowChar;

    private $alerts   = [];
    private $colIdent = [];
    private $rowIdent = [];
    private $pwCard   = [];

    /**
     * Creates an instance of PassCard.
     * Is fetching all relevant variables from environmental variables to instance variables.
     * Finally calling the createCard-Method.
     */
    function __construct () {
        $this->charList         = env('CHARLIST', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');

        $this->matrixWidth      = env('MATRIXWIDTH', 26);
        $this->matrixHeight     = env('MATRIXHEIGHT', 12);

        $this->diagonalEscape   = env('DIAGESC', true);
        $this->horizontalEscape = env('HORIESC', true);
        $this->verticalEscape   = env('VERTESC', true);

        $this->colChar          = env('COLCHAR', 'A');
        $this->rowChar          = env('ROWCHAR', '1');

        $this->createCard();
    }

    /**
     * building up the Matrix that will be rendered as PassCard.
     * @return void
     */
    function createCard () {

        $defalert = env('DEFAULTINFO');
        if ($defalert != null and $defalert != '') {
            $this->alerts[] = [
                'message' => $defalert,
            ];
        }

        $pers = env('PERSISTENCE');
        if ($pers != NULL) {
            mt_srand((int) $pers);
        }
        elseif (isset($_GET['persistent'])) {
            $_GET['persistent'] = (int) $_GET['persistent'];
            if ($_GET['persistent'] >= env('MINPERSSEED', 1000)) {
                mt_srand($_GET['persistent']);
            }
            else {
                $this->alerts[] = [
                    'strong'  => 'Fehler:',
                    'type'    => 'danger',
                    'message' => 'Der Persistenz-Wert ist zu gering, er muss mindestens die Zahl ' . env('MINPERSSEED', 1000) . ' sein, übergeben wurde ' . $_GET['persistent'] . '. Die angezeigte Passwortkarte ist zufällig erzeugt.',
                ];
            }
        }

        for ($i = 0; $i < $this->matrixHeight; $i++) {

            $this->pwCard[$i] = [];

            for ($j = 0; $j < $this->matrixWidth; $j++) {

                $char = NULL;

                if ($this->colChar != NULL) {
                    $this->colIdent [] = ($this->colChar++);
                }

                do {
                    $charIndex = mt_rand(0, strlen($this->charList)-1);
                    $char = $this->charList[$charIndex];
                } while (
                    ($this->diagonalEscape   and ( $i > 0 and (
                        ($j > 0 and $this->pwCard[$i-1][$j-1] == $char) or
                        ($j < $this->matrixWidth - 1 and $this->pwCard[$i-1][$j+1] == $char)
                    ))) or
                    ($this->horizontalEscape and ($j > 0 and $this->pwCard[$i][$j-1] == $char)) or
                    ($this->verticalEscape   and ($i > 0 and $this->pwCard[$i-1][$j] == $char))
                );

                $this->pwCard[$i][$j] = $char;
            }

            $this->colChar = NULL;
            $this->rowIdent[] = $i+1;
        }
    }

    /**
     * creates the full HTML output based on the
     * @return void
     */
    function renderCard () {
        global $twig;
        echo $twig->load('passcard.twig')->render([
            'rowIdent' => $this->rowIdent,
            'colIdent' => $this->colIdent,
            'rows'     => $this->pwCard,
            'alerts'   => $this->alerts,
            'srvquery' => $_SERVER['QUERY_STRING'],
        ]);
    }
}
