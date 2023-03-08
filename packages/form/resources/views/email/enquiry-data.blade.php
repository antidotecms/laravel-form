<x-mail::message>

<x-mail::panel>
<x-mail::table>
| Field         | Value         |
| ------------- | ------------- |
@foreach($data as $name => $value)
| {{ $name }}   | {{ $value }}  |
@endforeach
</x-mail::table>
</x-mail::panel>

</x-mail::message>