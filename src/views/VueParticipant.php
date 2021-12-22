<?php
//TD13
namespace mywishlist\views;
class VueParticipant
{
    private $list;

    /**
     * Classic constructor
     * @param $data
     */
    public function __construct($data){
        $this->list = $data;
    }

    /**
     * Display a list
     * @param $liste
     * @return string
     */
    private function displayListe($liste)
    {
        $html = "<tr>";
        $html .= "<td>".$liste["titre"]."</td>";
        $html .= "<td>".$liste["description"]."</td>";
        $html .= "<td>".$liste["expiration"]."</td>";
        $html .= "</tr>";
        return $html;

    }

    /**
     * Display list and its items
     * @param $liste
     * @return string
     */
    private function displayListeItems($liste)
    {
        $html = "<th>";
        $html .= "<td>".$liste["titre"]."</td>";
        $html .= "<td>".$liste["description"]."</td>";
        $html .= "<td>".$liste["expiration"]."</td>";
        $html .= "</th><tr>";
        $liste = \mywishlist\models\Item::where('liste_id',"=",$liste["no"])->get()->toArray();
        foreach ($liste as $item) {
           $html.= $this->displayItem($item);
        }
        $html.="</tr>";
        return $html;
    }

    /**
     * Dispay item
     * @param $item
     * @return string
     */
    private function displayItem($item)
    {
        $html = "<tr>";
        $html .= "<td>".$item["nom"]."</td>";
        $html .= "<td>".$item["descr"]."</td>";
        $html .= "<td>".$item["tarif"]."</td>";
        $html .= "<td><img src='../../web/img/".$item["img"]."' alt='item' class='item-image'></td>";
        $html .= "</tr>";
        return $html;
    }

    /**
     * Generate render HTML code
     * @param $type
     * @return string
     */
    public function render($type)
    {
        $html = <<<HTML
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../web/css/main.css">
    <style>
   
    img{
    height: 100px;
    width: auto;
    }
    td,tr{
    border: black 1px solid;
    color: black;
    }
</style>
    <title>MyWishList</title>
</head>
<body>
    <header>
        <nav class="container-large">
            <h1>
                <span>My</span><span class="text-purple">WishList</span>
            </h1>
            <img src="../../web/icons/user.svg" alt="user icon" class="user-icon">
        </nav>
    </header>

    <main>
            <div class="form-container">
            <form action="" method="get" class="id-form">
                <input type="text" placeholder="ID de votre liste" class="form-input">
                <input type="submit" value="CHERCHER" class="form-submit">
            </form>
        </div>
<table>
HTML;
        switch ($type){
            case 1:
                foreach ($this->list as $l) {
                    $html.= $this->displayListe($l);
                }
                break;

            case 2:
                foreach ($this->list as $l) {
                    $html.= $this->displayListeItems($l);
                }
                break;
            case 3:
                $html.=$this->displayItem($this->list[0]);
        }

            $html .= <<<HTML
    </table>
      </main>
    </body>
    </html>
    
    HTML;

    return $html;
    }

}