<h1>Danh sách bằng cấp</h1>
{{$new_content}}</br>
{{$new_title }}</br>
{{ 'HungNguyen' }}</br>
{{md5('123456789')}}</br>
@if (!empty($new_title))
<p>{{$new_title}}</p>
@else
<p>Nothing</p>
@endif
@php
$number = 1;
$number++;
@endphp
{{$number}}
@for ($i=0;$i<=5;$i++)
<p>{{$i}}</p>
@endfor

@php
$i=0;
@endphp
@while ($i<=8)
<p>{{$i}}</p>
@php
$i++;
@endphp
@endwhile

@php
$data = [
    'Chunk',
    'Vegeta',
    'Gogeta'
];
@endphp
@foreach ($data as $item)
<p>{{$item}}</p>
@endforeach


