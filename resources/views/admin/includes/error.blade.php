<?php
$message = Session::get('message');
if ($message){
?>
<div class = "alert alert-success alert-dismissable">
    <button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true">
        &times;
    </button>
    <strong>Success!</strong> <span><?php  echo $message; ?></span>
</div>
<?php
Session::put('message','');
}

?>

<?php
$expression = Session::get('expression');
if ($expression){
?>
<div class = "alert alert-warning alert-dismissable">
    <button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true">
        &times;
    </button>
    <strong>Warning!</strong> <span><?php  echo $expression; ?></span>
</div>
<?php
Session::put('expression','');
}
?>

@if($errors)
    @foreach ($errors->all() as $error)
        <div class = "alert alert-warning alert-dismissable">
            <button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true">
                &times;
            </button>
            <strong>Warning!</strong> <span>{{ $error }}</span>
        </div>

    @endforeach
@endif