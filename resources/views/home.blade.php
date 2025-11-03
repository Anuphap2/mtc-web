<x-public-layout>

    {{-- 1. HERO SLIDER --}}
    <x-home.hero-slider :featuredPosts="$featuredPosts" />


    {{-- 2. DIRECTOR'S WELCOME --}}
    <x-home.director-welcome />

    {{-- 3. POSTS BY CATEGORY --}}
    <x-home.category-posts :categoriesWithPosts="$categoriesWithPosts" />

    {{-- 4. E-SERVICE LINKS --}}
    <x-home.eservice-links />

    {{-- 5. DEPARTMENTS --}}
    <x-home.departments />

    {{-- 6. CTA APPLY --}}
    <x-home.cta-apply />

</x-public-layout>
