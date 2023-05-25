<table>
    <tbody>
        @foreach ($febricParts as $item)
        <tr>
            <td><input onchange="changeItem({{ $item->id }})" type="text" name="" value="{{ $item->name }}" id="{{ $item->id }}name"></td>
            <td><input onchange="changeItem({{ $item->id }})" type="number" name="" value="{{ $item->value }}" id="{{ $item->id }}value"></td>
        </tr>
        @endforeach
    </tbody>
</table>
