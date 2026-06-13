<div class="col-xl-3" style="height: auto;">
    <!-- filters for search property -->
    <div class="card" style="border-radius: 20px; border: solid 1px #b7b7b7; backdrop-filter: blur(20px); position: sticky; top: 120px; ">
        <div class="card-body">
            <form method="GET" action="{{ route('marketplace') }}">
                <div class="mb-3">
                    <label for="budget" class="form-label">Budget</label>
                    <div class="d-flex align-items-center">
                        <select class="form-select me-2" id="budget" name="budget">
                            <option class="">Min</option>
                            <option class="">5 Lakhs</option>
                            <option class="">10 Lakhs</option>
                            <option class="">20 Lakhs</option>
                            <option class="">50 Lakhs</option>
                            <option class="">1 Crore</option>
                        </select>
                        <select class="form-select" id="location" name="location">
                            <option class="">Max</option>
                            <option class="">5 Lakhs</option>
                            <option class="">10 Lakhs</option>
                            <option class="">20 Lakhs</option>
                            <option class="">50 Lakhs</option>
                            <option class="">1 Crore</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="accordion border-0" id="propertyAccordion">
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-white text-dark fw-semibold px-0"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#propertyTypes">
                                    Type of property
                                </button>
                            </h2>

                            <div id="propertyTypes"
                                class="accordion-collapse collapse show"
                                data-bs-parent="#propertyAccordion">

                                <div class="accordion-body px-0">

                                    <div class="d-flex flex-wrap gap-3">

                                        <button type="button"
                                                class="btn btn-outline-secondary rounded-pill px-4">
                                            + Residential Apartment
                                        </button>

                                        <button type="button"
                                                class="btn btn-outline-secondary rounded-pill px-4">
                                            + Independent House/Villa
                                        </button>

                                        <button type="button"
                                                class="btn btn-outline-secondary rounded-pill px-4">
                                            + Residential Land
                                        </button>

                                        <button type="button"
                                                class="btn btn-outline-secondary rounded-pill px-4">
                                            + Independent/Builder Floor
                                        </button>

                                        <button type="button"
                                                class="btn btn-outline-secondary rounded-pill px-4">
                                            + Farm House
                                        </button>

                                        <button type="button"
                                                class="btn btn-outline-secondary rounded-pill px-4">
                                            + Serviced Apartments
                                        </button>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="accordion border-0 mt-4" id="bedroomAccordion">
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-white text-dark fw-semibold px-0"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#bedroomTypes">
                                    No. of Bedrooms
                                </button>
                            </h2>

                            <div id="bedroomTypes"
                                class="accordion-collapse collapse show"
                                data-bs-parent="#bedroomAccordion">

                                <div class="accordion-body px-0">

                                    <div class="d-flex flex-wrap gap-3">

                                        <input type="checkbox" class="btn-check" id="bhk1">
                                        <label class="btn btn-outline-secondary rounded-pill px-4" for="bhk1">
                                            1 BHK
                                        </label>

                                        <input type="checkbox" class="btn-check" id="bhk2">
                                        <label class="btn btn-outline-secondary rounded-pill px-4" for="bhk2">
                                            2 BHK
                                        </label>

                                        <input type="checkbox" class="btn-check" id="bhk3">
                                        <label class="btn btn-outline-secondary rounded-pill px-4" for="bhk3">
                                            3 BHK
                                        </label>

                                        <input type="checkbox" class="btn-check" id="bhk4">
                                        <label class="btn btn-outline-secondary rounded-pill px-4" for="bhk4">
                                            4 BHK
                                        </label>

                                        <input type="checkbox" class="btn-check" id="bhk5">
                                        <label class="btn btn-outline-secondary rounded-pill px-4" for="bhk5">
                                            5 BHK
                                        </label>

                                        <input type="checkbox" class="btn-check" id="bhk6">
                                        <label class="btn btn-outline-secondary rounded-pill px-4" for="bhk6">
                                            6+ BHK
                                        </label>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div mb-3>
                    <div class="accordion border-0 mt-4" id="constructionAccordion">
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-white text-dark fw-semibold px-0"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#constructionStatus">
                                    Construction Status
                                </button>
                            </h2>

                            <div id="constructionStatus"
                                class="accordion-collapse collapse show"
                                data-bs-parent="#constructionAccordion">

                                <div class="accordion-body px-0">

                                    <div class="d-flex flex-wrap gap-3">

                                        <input type="checkbox" class="btn-check" id="newLaunch" name="construction_status[]" value="new_launch">
                                        <label class="btn btn-outline-secondary rounded-pill px-4" for="newLaunch">
                                            New Launch
                                        </label>

                                        <input type="checkbox" class="btn-check" id="underConstruction" name="construction_status[]" value="under_construction">
                                        <label class="btn btn-outline-secondary rounded-pill px-4" for="underConstruction">
                                            Under Construction
                                        </label>

                                        <input type="checkbox" class="btn-check" id="readyToMove" name="construction_status[]" value="ready_to_move">
                                        <label class="btn btn-outline-secondary rounded-pill px-4" for="readyToMove">
                                            Ready to Move
                                        </label>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>