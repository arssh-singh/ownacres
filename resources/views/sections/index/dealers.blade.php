
@php
$agents = [
    [
        'name' => 'Sarah Mitchell',
        'title' => 'Luxury Property Specialist',
        'image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=1200&q=90',
        'sales' => 142,
        'rating' => 4.9,
    ],
    [
        'name' => 'James Carter',
        'title' => 'Residential Expert',
        'image' => asset('storage/images/arsh.jpg'),
        'sales' => 117,
        'rating' => 5.0,
    ],
    [
        'name' => 'Emma Roberts',
        'title' => 'Investment Advisor',
        'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=1200&q=90',
        'sales' => 98,
        'rating' => 4.8,
    ],
    [
        'name' => 'Michael Wilson',
        'title' => 'Commercial Specialist',
        'image' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=1200&q=90',
        'sales' => 164,
        'rating' => 5.0,
    ],
];
@endphp
 <section class="agents-section py-6 bg-light">

    <div class="container pt-5">

        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center">

                <span class="section-badge">
                    PROFESSIONAL AGENTS
                </span>

                <h2 class="display-4 fw-bold mt-3">
                    Meet The Experts Behind
                    Every Successful Deal
                </h2>

                <p class="lead text-secondary mt-3">
                    Our experienced agents combine market knowledge,
                    negotiation expertise and local insights to help
                    you find the perfect property.
                </p>

            </div>
        </div>

        <div class="row g-4">

            @foreach($agents as $agent)

                <div class="col-lg-3 col-md-6">

                    <div class="agent-card">

                        <div class="agent-image-wrapper">

                            <img
                                src="{{ $agent['image'] }}?w=800&q=80"
                                alt="{{ $agent['name'] }}"
                                class="agent-image"
                            >

                            <div class="agent-overlay">

                                <a href=""
                                   class="btn btn-light rounded-pill px-4">
                                    View Profile
                                </a>

                            </div>

                        </div>

                        <div class="agent-content">

                            <div class="agent-rating">
                                ★ {{ $agent['rating'] }}
                            </div>

                            <h4>
                                {{ $agent['name'] }}
                            </h4>

                            <p>
                                {{ $agent['title'] }}
                            </p>

                            <div class="agent-stats">

                                <div>
                                    <strong>{{ $agent['sales'] }}+</strong>
                                    <span>Properties Sold</span>
                                </div>

                                <div>
                                    <strong>7 Years</strong>
                                    <span>Experience</span>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>
<style>
    .agents-section{
    background:
    linear-gradient(
        180deg,
        #ffffff 0%,
        #f8fafc 100%
    );
}

.section-badge{
    display:inline-block;
    padding:.6rem 1rem;
    background:#eef2ff;
    color:#4f46e5;
    border-radius:50px;
    font-size:.8rem;
    font-weight:600;
    letter-spacing:1px;
}

.agent-card{
    background:#fff;
    border-radius:24px;
    overflow:hidden;
    transition:.4s;
    height:100%;
    box-shadow:
    0 10px 40px rgba(0,0,0,.05);
}

.agent-card:hover{
    transform:translateY(-10px);
    box-shadow:
    0 30px 60px rgba(0,0,0,.12);
}

.agent-image-wrapper{
    position:relative;
    overflow:hidden;
    height:340px;
}

.agent-image{
    width:100%;
    height:100%;
    object-fit:cover;
    transition:.6s;
}

.agent-card:hover .agent-image{
    transform:scale(1.08);
}

.agent-overlay{
    position:absolute;
    inset:0;
    background:
    linear-gradient(
        transparent,
        rgba(0,0,0,.65)
    );

    display:flex;
    align-items:flex-end;
    justify-content:center;

    padding:30px;

    opacity:0;
    transition:.3s;
}

.agent-card:hover .agent-overlay{
    opacity:1;
}

.agent-content{
    padding:1.8rem;
}

.agent-content h4{
    font-weight:700;
    margin-bottom:.3rem;
}

.agent-content p{
    color:#6c757d;
    margin-bottom:1.4rem;
}

.agent-rating{
    color:#f59e0b;
    font-weight:600;
    margin-bottom:.7rem;
}

.agent-stats{
    display:flex;
    justify-content:space-between;
    padding-top:1rem;
    border-top:1px solid #eee;
}

.agent-stats strong{
    display:block;
    font-size:1.1rem;
}

.agent-stats span{
    font-size:.85rem;
    color:#6c757d;
}
</style>