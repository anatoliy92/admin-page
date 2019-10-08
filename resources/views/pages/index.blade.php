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
			@can('update', $section)
				<div class="card-actions">
					<button type="submit" form="submit" name="button" value="save" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
				</div>
			@endcan
		</div>

		<div class="card-body">
			@canany(['update'], $section)
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
				</form>
			@elsecanany(['view'], $section)
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
							{!! $section->page->{'description_' . $lang->key} ?? null !!}
						</div>
					@endforeach

					@if (array_key_exists('image', $section->modules ?? []))
						<div class="tab-pane" id="image" role="tabpanel">
							<div class="row">
								<div class="photo--news col-lg-12">
									<ul class="row list-unstyled">
										@php $images = $section->page->media('image')->orderBy('sind', 'DESC')->get(); @endphp
										@if ($images)
											@foreach ($images as $image)
												<li class="col-6 col-sm-4 col-xl-3 col-xxl-2">
													<div class="card card-stat">
														<div class="card-header">
															<div class="row">
																<div class="col-6 text-left"><i class="fa fa-eye{{ ($image['good'] == 0) ? '-slash' : '' }}"></i></div>
																<div class="col-6 text-right"><img src="/avl/img/icons/flags/{{ $image['lang'] ?? 'null' }}--16.png"></div>
															</div>
														</div>
														<div class="card-body p-0">
															<img src="/image/resize/200/190/{{ $image['url'] }}" style="width: 100%;">
														</div>
													</div>
												</li>
											@endforeach
										@endif
									</ul>
								</div>
							</div>
						</div>
					@endif

					@if (array_key_exists('file', $section->modules ?? []))
						<div class="tab-pane" id="file" role="tabpanel">
							<div class="row files--news">
								<div class="col-md-12">
									<ul class="list-group">
										@php $files = $section->page->media('file')->orderBy('sind', 'DESC')->get(); @endphp
										@if ($files)
											@foreach ($files as $file)
												<li class="col-md-12 list-group-item files--item">
													<div class="img-thumbnail">
														<div class="input-group">
															<div class="input-group-prepend">
																<span class="input-group-text"><img src="/avl/img/icons/flags/{{ $file['lang'] ?? 'null' }}--16.png"></span>
																<span class="input-group-text"><i class="fa @if($file['good'] == 1){{ 'fa-eye' }}@else{{ 'fa-eye-slash' }}@endif"></i></span>
																<span class="input-group-text"><a href="/file/save/{{ $file['id'] }}" target="_blank"><i class="fa fa-download"></i></a></span>
															</div>
															<input type="text" class="form-control" value="{{ $file['title_' . $file['lang'] ] }}">
														</div>
													</div>
												</li>
											@endforeach
										@endif
									</ul>
								</div>
							</div>
						</div>
					@endif
				</div>
			@endcanany
		</div>

		<div class="card-footer position-relative">
			<i class="fa fa-align-justify"></i> {{ $section->name_ru }}
			@can('update', $section)
				<div class="card-actions">
					<button type="submit" form="submit" name="button" value="save" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
				</div>
			@endcan
		</div>
	</div>
@endsection

@section('js')
	<script src="/avl/js/tinymce/tinymce.min.js" charset="utf-8"></script>

	<script src="/avl/js/jquery-ui/jquery-ui.min.js" charset="utf-8"></script>
	<script src="/avl/js/uploadifive/jquery.uploadifive.min.js" charset="utf-8"></script>

	<script src="{{ asset('vendor/adminpage/js/page.js') }}" charset="utf-8"></script>
@endsection
