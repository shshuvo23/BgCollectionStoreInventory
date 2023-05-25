
        @foreach ($febricParts as $item)
            <div class="row" style="margin: 0; padding: 0;">
                <div class="col-8" style="margin: 0; padding: 0;">
                    <input style="width: 100%; font-size: 10px;" onchange="changeItem({{ $item->id }})" type="text" name="" value="{{ $item->name }}" id="{{ $item->id }}name">
                </div>
                <div class="col-4" style="margin: 0; padding: 0;">
                    <input  style="width: 100%; font-size: 10px;" onchange="changeItem({{ $item->id }})" type="number" name="" value="{{ $item->value }}" id="{{ $item->id }}value">
                </div>
            </div>
        @endforeach


