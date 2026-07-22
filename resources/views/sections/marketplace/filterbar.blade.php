<div class="col-xl-3">
    <form id="searchForm">
        @csrf

        <div class="input-group shadow-sm">
            <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-search text-muted"></i>
            </span>

            <input
                type="text"
                class="form-control border-start-0"
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
</div>