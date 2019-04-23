<li class="col-6 col-sm-4 col-xl-3 col-xxl-2" id="mediaSortable_{{ $image['id'] }}">
	<div class="card card-stat">
		<div class="card-header">
			<div class="row">
				<div class="col-6 text-left">
					<a href="#" class="change--status" data-model="App\Models\Media" data-id="{{ $image['id'] }}"><i class="fa fa-eye{{ ($image['good'] == 0) ? '-slash' : '' }}"></i></a>
				</div>
				<div class="col-6 text-right">
					<a href="" class="change--lang" data-id="{{ $image['id'] }}"><img src="/avl/img/icons/flags/{{ $image['lang'] ?? 'null' }}--16.png"></a>
				</div>
			</div>
		</div>
		<div class="card-body p-0">
			<img src="{{ env('STORAGE_URL') . $image['url'] }}">
		</div>
		<div class="card-footer">
			<div class="row">
				<div class="col-6 text-left"><a href="#" class="deleteMedia" data-id="{{ $image['id'] }}"><i class="fa fa-trash-o"></i></a></div>
				<div class="col-6 text-right"><a href="#" class="open--modal-translates" data-id="{{ $image['id'] }}" data-toggle="modal" data-target="#translates-modal"><i class="fa fa-pencil"></i></a></div>
			</div>
		</div>
	</div>
</li>
