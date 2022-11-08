 <div class="table-responsive">
    <table class="table table-striped- table-hover table-checkable dataTable no-footer dtr-inline collapsed " id="m_table_1">
        <thead>
            <tr>
                <th>No.</th>
                <th>Product</th>
                <th>No. of Sold</th>
            </tr>
        </thead>
        <tbody>
            @if(count($best_selling_product_qty) == 0)
            <tr>
                <td colspan="8" style="text-align:center;">No record found</td>
            </tr>
            @endif
            <?php $i=0; ?>
            @foreach($best_selling_product_qty as $key => $product)
            <?php 
            $i++;
            ?>
            <tr>
                <td>{{ $i }}</td>
                <td><a class="linkremove" href="{{ route('seller.products.show', [App\Helpers\Helper::encrypt($product->id)]) }}">{{ $product->name}}</a></td>
                <td>{{ $product->total }}</td>
            </tr>
       
            @endforeach
        </tbody>
    </table>
</div>
