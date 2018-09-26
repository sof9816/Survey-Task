<?php 

class Survey
{
    var $pages = array();
    var $qusetions = array();
    var $answers = array();

    var $numOfpages = array();
    var $numOfQPerP = array();
    var $numOfAPerQ = array();

    function __construct($p, $q, $a)
    {
        $this->pages[$p] = $p;
        $this->qusetions[$q . $p] = $q;
        $this->answers[$a . $q . $p] = $a;
        $this->numOfpages[1] = 1;
        $this->numOfQPerP[1] = 1;
        $this->numOfAPerQ[1] = 1;


    }
    public function addPage($pNum)
    {
        $this->pages[$pNum] = $pNum;
        addQus($pNum, $qNum);
        $this->numOfpages[1]++;
    }
    public function addQus($pNum, $qNum)
    {
        $this->qusetions[$pNum . $qNum] = $qNum;
        $this->numOfQPerP[$pNum]++;
    }
    public function addAnsr($qNum, $pNum, $aNum)
    {
        $this->answers[$aNum . $qNum . $pNum] = $aNum;
        $this->numOfAPerQ++;
    }
    public function getPage()
    {
        return $this->pages[$this->numOfpages];
    }
    public function getQus()
    {
        return $this->qusetions[$this->numOfpages . $this->numOfQPerP];
    }
    public function getAnsr()
    {
        return $this->answers[$this->numOfQPerP . $this->numOfQPerP . $this->numOfAPerQ];
    }

}

$survey = new Survey(1, 1, 1);

function page($p)
{
    echo '

        <label for="">
            Page ' . $p . '
        </label>
        <a class="b glyphicon glyphicon-plus"  id="addp"></a>
        <hr>
           
';
}
function qus($q)
{
    echo '
    <label for="" class="r">
    Question ' . $q . ' :
    <input type="text" class="q" name="qus">
</label>
    <a class="b glyphicon glyphicon-plus" id="addq"></a>

';
}
function ansr($a)
{
    echo '  <br>
<br>
<label for="" class="g">
    Answer ' . $a . ' :
    <input type="text" name="ansr">
</label>
     <a class="b glyphicon glyphicon-plus" id="adda"></a>';
}
?>