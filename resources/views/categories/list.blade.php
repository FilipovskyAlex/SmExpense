<div class="col-sm-4 offset-2 categories-table">
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th>Name (№ of budgets)</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($categories))
                    @foreach($categories as $category)
                        <tr>
                            <td style="width: 80%">{{ $category->name }} ({{ $category->budgets }})</td>
                            <td style="width: 10%"><a href="{{ route('category.edit', $category->id) }}"><i class="fa fa-edit"></i></a></td>
                            <td style="width: 10%"><a href="{{ route('category.delete', $category->id) }}"><i class="fa fa-trash"></i></a></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
