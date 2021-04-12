<?php require APPROOT . '/views/inc/header.php'; ?>
<h5 class="mb-3"> Listing des messages archivés </h5>
<form action="<?php  echo URLROOT; ?>/chats/send" method="post">
<input type="text" name="msg" class="form-control mb-2 mt-2" placeholder ="type new message">
<div class="col">
        <button type="submit" class="btn btn-success mb-2">Send</button>
</div>
</form>
<?php foreach($data['messages'] as $msg) : ?>
  <div class="card card-body mb-2">
    <h6><?php  echo $msg->message; ?></h6> 
    <div class="bg-light p-2 mb-2">
    Send by <?php  echo $msg->name; ?> on <?php echo $msg->createdAt;?>
    </div>  
  </div>
<?php endforeach; ?>
<h5 class="mb-3"> Listes des connectés </h5>
<?php foreach($data['users'] as $user) : ?>
  <div class="card card-body mb-2">
    <div class="bg-light p-2 mb-2">
    <?php echo $user->name; ?> 
    </div>  
  </div>
<?php endforeach; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
  