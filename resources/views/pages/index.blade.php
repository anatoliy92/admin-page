@extends('avl.default')

@section('css')
	<link rel="stylesheet" href="/avl/js/jquery-ui/jquery-ui.min.css">
	<link rel="stylesheet" href="/avl/js/uploadifive/uploadifive.css">
	<link rel="stylesheet" href="/avl/js/jquery-ui/timepicker/jquery.ui.timepicker.css">
@endsection

@section('main')
	<div class="card">
		<div class="card-header">
			<i class="fa fa-align-justify"></i> {{ $section->name_ru }}
			<div class="card-actions">
				<button type="submit" form="submit" name="button" value="save" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
			</div>
		</div>

		<div class="card-body">
			<form action="{{ route('adminpage::sections.page.update', ['id' => $section->id, 'page' => $section->page->id]) }}" method="post" id="submit">
				{!! csrf_field(); !!}
				{{ method_field('PUT') }}
				{{ Form::hidden(null, $section->id, ['id' => 'section_id']) }}
				{{ Form::hidden(null, "Avl\AdminPage\Models\Page", ['id' => 'model-name']) }}
				{{ Form::hidden(null, $section->page->id, ['id' => 'model-id']) }}

				<ul class="nav nav-tabs" role="tablist">
					@foreach($langs as $lang)
						<li class="nav-item">
							<a class="nav-link @if($lang->key == "ru") active show @endif" href="#{{ $lang->key }}" data-toggle="tab"> {{ $lang->name }} </a>
						</li>
					@endforeach

					@if (array_key_exists('image', $section->modules ?? [])) <li class="nav-item"><a class="nav-link" href="#image" data-toggle="tab">Фото</a></li> @endif

					@if (array_key_exists('file', $section->modules ?? [])) <li class="nav-item"><a class="nav-link" href="#file" data-toggle="tab">Файлы</a></li> @endif
				</ul>
				<div class="tab-content">
					@foreach ($langs as $lang)
						<div class="tab-pane @if ($lang->key == "ru") active show @endif"  id="{{ $lang->key }}" role="tabpanel">
							{{ Form::textarea('page_description_' . $lang->key, $section->page->{'description_' . $lang->key} ?? null, ['class' => 'tinymce'] ) }}
						</div>
					@endforeach

					@if (array_key_exists('image', $section->modules ?? []))
						<div class="tab-pane" id="image" role="tabpanel">
							<div class="block--file-upload">
								<input id="upload-photos" name="upload" type="file" />
							</div>
							<div class="row">
								<div class="photo--news col-lg-12">
									<ul id="sortable" class="row list-unstyled">
										@php $images = $section->page->media('image')->orderBy('sind', 'DESC')->get(); @endphp
										@if ($images)
											@foreach ($images as $image)
												@include('adminpage::pages.snippets.image')
											@endforeach
										@endif
									</ul>
								</div>
							</div>
						</div>
					@endif

					@if (array_key_exists('file', $section->modules ?? []))
						<div class="tab-pane" id="file" role="tabpanel">
							<div class="block--file-upload">
								<div class="form-group">
									<select class="form-control" id="select--language-file">
										@foreach($langs as $lang)
											<option value="{{ $lang->key }}">{{ $lang->key }}</option>
										@endforeach
									</select>
								</div>
								<input id="upload-files" name="upload" type="file" />
							</div>
							<div class="row files--news">
								<div class="col-md-12">
									<ul id="sortable-files" class="list-group">
										@php $files = $section->page->media('file')->orderBy('sind', 'DESC')->get(); @endphp
										@if ($files)
											@foreach ($files as $file)
												@include('adminpage::pages.snippets.file')
											@endforeach
										@endif
									</ul>
								</div>
							</div>
						</div>
					@endif
				</div>
				<br/>
			</form>
		</div>

		<div class="card-footer position-relative">
			<i class="fa fa-align-justify"></i> {{ $section->name_ru }}
			<div class="card-actions">
				<button type="submit" form="submit" name="button" value="save" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script src="/avl/js/tinymce/tinymce.min.js" charset="utf-8"></script>

	<script src="/avl/js/jquery-ui/jquery-ui.min.js" charset="utf-8"></script>
	<script src="/avl/js/uploadifive/jquery.uploadifive.min.js" charset="utf-8"></script>

	<script src="{{ asset('vendor/adminpage/js/page.js') }}" charset="utf-8"></script>
@endsection
