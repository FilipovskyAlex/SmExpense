<div class="col-sm-5 periods-table">
    <div>
        <table class="table">
            <thead>
            <tr>
                <th>From</th>
                <th>To</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($periods))
                @foreach($periods as $period)
                    <tr>
                        <td style="width: 40%">{{ $period->from }}</td>
                        <td style="width: 40%">{{ $period->to }}</td>
                        <td style="width: 10%"><a href="{{ route('period.edit', $period->id) }}"><i class="fa fa-edit"></i></a></td>
                        <td style="width: 10%"><a href="{{ route('period.delete', $period->id) }}"><i class="fa fa-trash"></i></a></td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
