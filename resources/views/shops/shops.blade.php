@if ($lists)
    <div class="row">
        @foreach ($lists as $list)
            <div class="item">
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            <img src="{{ $list['image_url'] }}" alt="">
                        </div>
                        <div class="panel-body">
                            <p class="list-title"><a href="{{$list['url']}}">{{ $list['name'] }}</a></p>
                            
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif