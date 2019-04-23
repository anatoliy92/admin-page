<li class="col-md-12 list-group-item files--item" id="mediaSortable_{{ $file['id'] }}">
	<div class="img-thumbnail">
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text"><a href="" class="change--lang" data-id="{{ $file['id'] }}"><img src="/avl/img/icons/flags/{{ $file['lang'] ?? 'null' }}--16.png"></a></span>
				<span class="input-group-text file-move" style="cursor: move;"><i class="fa fa-arrows"></i></span>
				<span class="input-group-text"><a href="#" class="change--status" data-model="App\Models\Media" data-id="{{ $file['id'] }}"><i class="fa @if($file['good'] == 1){{ 'fa-eye' }}@else{{ 'fa-eye-slash' }}@endif"></i></a></span>
				<span class="input-group-text"><a href="/file/save/{{ $file['id'] }}" target="_blank"><i class="fa fa-download"></i></a></span>
				<span class="input-group-text"><a href="#" class="deleteMedia" data-id="{{ $file['id'] }}"><i class="fa fa-trash-o"></i></a></span>
			</div>
			<input type="text" id="title--{{ $file['id'] }}" class="form-control" value="{{ $file['title_' . $file['lang'] ] }}">
			<div class="input-group-append">
				<a href="#" class="input-group-text save--file-name" data-id="{{ $file['id'] }}"><i class="fa fa-floppy-o"></i></a>
			</div>
		</div>
	</div>
</li>
