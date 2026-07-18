
<div class="col-xl-3">

    <form id="searchForm">

        @csrf

        <!-- Search -->
        <div class="mb-4">
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search"></i>
                </span>

                <input
                    type="text"
                    class="form-control"
                    id="propertySearch"
                    name="search"
                    placeholder="Search properties..."
                    autocomplete="off"
                >

                <button class="btn btn-primary" type="submit">
                    Search
                </button>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="card shadow-sm border-0"
             style="border-radius:20px;position:sticky;top:120px;">

            <div class="card-body">

                <h5 class="fw-bold mb-4">Filters</h5>

                <!-- Listing Type -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Listing Type</label>
                    <select class="form-select" name="listing_type">
                        <option value="">Any</option>
                        <option value="sale">Buy</option>
                        <option value="rent">Rent</option>
                    </select>
                </div>

                <!-- Budget -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">Budget</label>

                    <div class="row g-2">
                        <div class="col-6">
                            <select class="form-select" name="budget_min">
                                <option value="">Min</option>
                                <option value="500000">5 Lakh</option>
                                <option value="1000000">10 Lakh</option>
                                <option value="2000000">20 Lakh</option>
                                <option value="5000000">50 Lakh</option>
                                <option value="10000000">1 Crore</option>
                                <option value="20000000">2 Crore</option>
                            </select>
                        </div>

                        <div class="col-6">
                            <select class="form-select" name="budget_max">
                                <option value="">Max</option>
                                <option value="5000000">50 Lakh</option>
                                <option value="10000000">1 Crore</option>
                                <option value="20000000">2 Crore</option>
                                <option value="50000000">5 Crore</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Optional Apply Button -->
                <button type="submit" class="btn btn-primary w-100">
                    Apply Filters
                </button>

            </div>
        </div>

    </form>

</div>