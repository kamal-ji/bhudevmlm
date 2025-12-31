<div class="pagination-controls">
    <div class="d-flex justify-content-between">
        <div>
            <!-- Display showing X to Y of Z customers -->
            <span>
                Showing 
                {{ ($filters['page'] - 1) * $filters['count'] + 1 }} 
                to 
                {{ min($filters['page'] * $filters['count'], $data->total()) }} 
                of 
                {{ $data->total() }} customers
            </span>
        </div>
        <div>
            <!-- Display pagination links -->
            {{ $data->links() }}
        </div>
    </div>
</div>
