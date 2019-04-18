@extends('avl.default')

@section('main')
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> {{$section->name_ru}}
        <div class="card-actions">
          <button type="submit" form="submit" name="button" value="save" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('adminpage::sections.page.update', ['id' => $section->id, 'page' => $section->page->id]) }}" method="post" id="submit">
          {!! csrf_field(); !!}
          {{ method_field('PUT') }}
          <ul class="nav nav-tabs" role="tablist">
              @foreach($langs as $lang)
                <li class="nav-item">
                  <a class="nav-link @if($lang->key == "ru") active show @endif" href="#{{ $lang->key }}" data-toggle="tab"> {{ $lang->name }} </a>
                </li>
              @endforeach
          </ul>
          <div class="tab-content">
            @foreach ($langs as $lang)
              @php $description = 'description_' . $lang->key; @endphp
              <div class="tab-pane @if($lang->key == "ru") active show @endif"  id="{{$lang->key}}" role="tabpanel">
                <textarea class="form-control tinymce" name="page_description_{{$lang->key}}" rows="15">{{$section->page->$description}}</textarea>
              </div>
            @endforeach
          </div>
          <br/>
        </form>
      </div>
      <div class="card-footer position-relative">
        <i class="fa fa-align-justify"></i> {{$section->name_ru}}
        <div class="card-actions">
          <button type="submit" form="submit" name="button" value="save" class="btn btn-primary pl-3 pr-3" style="width: 70px;" title="Сохранить"><i class="fa fa-floppy-o"></i></button>
        </div>
      </div>
    </div>
@endsection

@section('js')
  <script src="/avl/js/tinymce/tinymce.min.js" charset="utf-8"></script>
@endsection
