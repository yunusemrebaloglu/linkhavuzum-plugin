
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

<div class="col-6">
	<div class="row">
		<div class="col-12">
					 <input type="text" value="[linkim_short_code]<?=$key->id?>[/linkim_short_code]"><br>
			<div class="row">
				<div class="col-8">

					<a href="<?=$key->link?>"><?=$key->title?></a>
					
					<br>
					<?=$key->content?><br>
					
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?=$i?>">
						Linkini Düzenle
					</button>
					<hr>
					<div class="modal fade" id="exampleModal<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Linkini Düzenle</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>

								</div>
								<div class="modal-body">
									<form method="post">
										<label >Linkiniz</label>
										<input class="form-control" type="text" name="link" value="<?=$key->link?>">
										<label >Açıklamanız</label>
										<textarea class="form-control" name="content" ><?=$key->content?></textarea>
										<input type="hidden" name="update" value="1">
										<input type="hidden" name="id" value="<?=$key->id?>">
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Çık</button>

										<a class="btn btn-danger" href="admin.php?delete=<?=$key->id?>&page=eklenti-flu%2Flinklerin.php">Sil</a>
										<button type="submit" class="btn btn-primary">Güncelle</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
