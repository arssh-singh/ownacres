<div class="col-xl-3">

    <!-- Search -->
    <form id="searchForm" class="mb-4">
        @csrf

        <div class="input-group shadow-sm">
            <span class="input-group-text bg-white border-end-0 border-dark">
                <i class="bi bi-search text-muted"></i>
            </span>

            <input
                type="text"
                class="form-control border-start-0 border-dark"
                id="propertySearch"
                name="search"
                placeholder="Search properties..."
                autocomplete="off"
            >

            <button class="btn btn-primary px-4" type="submit">
                Search
            </button>
        </div>
    </form>

    <!-- Filters -->
    <div class="card shadow-sm">
        <div class="card-body">

            <h6 class="fw-semibold mb-3">
                <i class="bi bi-funnel me-2"></i>Filters
            </h6>

            <form id="filterForm">

                <div class="mb-3">
                    <label class="form-label">Listing Type</label>
                    <select name="listing_type" class="form-select">
                        <option value="">All</option>
                        <option value="sale">Sale</option>
                        <option value="rent">Rent</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Maximum Price</label>
                    <input
                        type="number"
                        name="max_price"
                        class="form-control"
                        placeholder="e.g. 5000000">
                </div>

            </form>

        </div>
    </div>

</div>