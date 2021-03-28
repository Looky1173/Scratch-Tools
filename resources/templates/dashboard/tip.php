<div class="alert alert-secondary filled-dm w-400 mw-full" role="alert">
    <button class="close" onclick="this.parentNode.classList.add('dispose')" type="button" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <!-- w-400 = width: 40rem (400px), mw-full = max-width: 100% -->
    <div class="row align-items-center">
        <!-- align-items-center = align-items: center -->
        <div class="col-sm-2">
            <div class="w-50 h-50 d-flex align-items-center rounded-circle bg-secondary hidden-dm">
                <!-- w-50 = width: 5rem (50px), h-50 = height: 5rem (50px), d-flex = display: flex, align-items-center = align-items: center, rounded-circle = border-radius: 50%, bg-secondary = background-color: var(--secondary-color), hidden-dm = hidden in dark mode -->
                <div class="m-auto">
                    <!-- m-auto = margin: auto -->
                    <i class="fas fa-lightbulb fa-2x" aria-hidden="true"></i>
                    <span class="sr-only">Lightbulb</span> <!-- sr-only = only for screen readers -->
                </div>
            </div>
            <div class="w-50 h-50 d-flex align-items-center rounded-circle bg-white hidden-lm">
                <!-- w-50 = width: 5rem (50px), h-50 = height: 5rem (50px), d-flex = display: flex, align-items-center = align-items: center, rounded-circle = border-radius: 50%, bg-white = background-color: var(--white-bg-color), hidden-lm = hidden in light mode -->
                <div class="m-auto">
                    <!-- m-auto = margin: auto -->
                    <i class="far fa-lightbulb fa-2x" aria-hidden="true"></i>
                    <span class="sr-only">Lightbulb</span> <!-- sr-only = only for screen readers -->
                </div>
            </div>
        </div>
        <div class="col-sm-9 offset-sm-1 py-10">
            <!-- py-10 = padding-top: 1rem (10px) and padding-bottom: 1rem (10px) -->
            <h4 class="alert-heading">Here's a tip for you</h4>
            <div id="tip-placeholder">
                <div class="fake-content white"></div>
                <div class="fake-content white w-100"></div>
            </div>
            <script src="/js/dashboard/tip.js"></script>
        </div>
    </div>
</div>