
@foreach ($data as $customer)
<tr>
    <td>
        <div class="form-check form-check-md">
            <input class="form-check-input" type="checkbox">
        </div>
    </td>
    <td>
        <div class="d-flex align-items-center">
            <a href="customer-details.html" class="avatar avatar-sm rounded-circle me-2 flex-shrink-0">
                <img src="{{ $customer['image'] ? get('image_url') . $customer['image'] : asset('assets/backend/img/profiles/avatar-01.jpg') }}"
                    class="rounded-circle" alt="{{ $customer['name'] }}">
            </a>
            <div>
                <h6 class="fs-14 fw-medium mb-0"><a href="customer-details.html">{{ $customer['name'] }}</a></h6>
            </div>
        </div>
    </td>

    <td>{{ $customer['emailid'] }}</td>
    <td>{{ $customer['mobile'] ?? 'Unknown' }}</td>

    <td>
        <div class="d-flex align-items-center">
            <a href="add-invoice.html" class="btn btn-sm btn-outline-white d-inline-flex align-items-center me-1">
                <i class="isax isax-add-circle me-1"></i> Invoice
            </a>
            <a href="#" class="btn btn-sm btn-outline-white d-inline-flex align-items-center me-1"
                data-bs-toggle="modal" data-bs-target="#view-ledger">
                <i class="isax isax-document-text-1 me-1"></i> Ledger
            </a>
        </div>
    </td>
</tr>
@endforeach