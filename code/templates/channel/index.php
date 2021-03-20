<?php

/**
 * @var string $result
 * @var <Google_Service_YouTube_SearchResult> $data
 */

?>
<h1 class="h3 visually-hidden">Поиск канала</h1>

<form method="get">
    <div class="row mb-3">
        <div class="col col-lg-11 mx-auto">
            <input type="text" class="form-control" name="q" placeholder="Название канала">
        </div>
        <div class="col col-lg-1 mx-auto">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>

</form>

<div class="row">

</div>

<?php
/* @var Google_Service_YouTube_SearchResult $d */
foreach ($data as $d) {
//    var_dump($d->getSnippet()->title);
    echo '<p><a href="">' . $d->getSnippet()->channelTitle . '</a></p>';
}
?>

