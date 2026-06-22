<div class="col-xl-3" style="height: auto;">
    <!-- filters for search property -->
    <div class="card" style="border-radius: 20px; border: solid 1px #b7b7b7; backdrop-filter: blur(20px); position: sticky; top: 120px; ">
        <div class="card-body">
            <form id="searchForm">
                {{-- Budget Range --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Budget</label>
                    <div class="d-flex gap-2">
                        <select class="form-select" id="budget" name="budget_min">
                            <option value="0">Min</option>
                            <option value="500000">5 Lakhs</option>
                            <option value="1000000">10 Lakhs</option>
                            <option value="2000000">20 Lakhs</option>
                            <option value="5000000">50 Lakhs</option>
                            <option value="10000000">1 Crore</option>
                        </select>
                        <select class="form-select" id="budget_max" name="budget_max">
                            <option value="1000000000000000">Max</option>
                            <option value="500000">5 Lakhs</option>
                            <option value="1000000">10 Lakhs</option>
                            <option value="2000000">20 Lakhs</option>
                            <option value="5000000">50 Lakhs</option>
                            <option value="10000000">1 Crore</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>