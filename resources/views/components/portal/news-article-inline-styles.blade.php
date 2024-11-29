@props([
    'feature_image_small_url',
    'feature_image_large_url'
])

@push('styles')
        <style>
            #knowledgebaseNewsArticlePage header {
                background-image: 
                    /* Top overlay */
                    linear-gradient( rgba(221,234,242,0.64) 0%, #DDEAF2 100%),
                    linear-gradient(rgba(27,26,30,0.32) 0%, rgba(27,26,30,0.32) 100%),
                    /* Bottom background */
                    url({{ $feature_image_small_url }});
                background-position: center; 
                background-repeat: no-repeat;
                background-color: var(--light-gray-background);
                background-size: 
                    100%,
                    100%,
                    cover;
                padding-bottom: 1rem;
            }

            #knowledgebaseNewsArticlePage.dark-mode header {
                background-image: 
                    /* Top overlay */
                    radial-gradient(circle at bottom, rgba(7,28,48,0) 0%, rgba(12,12,22,0.94) 100%),
                    /* radial-gradient(circle at bottom, rgba(7,28,48,0) 0%, rgba(12,12,22,0.2) 70%, rgba(12,12,22,0.5) 100%), */
                    linear-gradient(rgba(27,26,30,0.32) 0%, rgba(27,26,30,0.32) 100%),
                    /* Bottom background */
                    url({{ $feature_image_small_url }});
                background-color: #0C0C16;
                background-size: 
                    100%,
                    cover;
            }

            @media (min-width: 700px) {
                #knowledgebaseNewsArticlePage header {
                    background-image: 
                        /* Top gradient */
                        linear-gradient( rgba(221,234,242,0.64) 0%, #DDEAF2 100%),
                        /* Bottom background */
                        url({{ $feature_image_large_url }});
                    padding-bottom: 2.5rem;
                }

                #knowledgebaseNewsArticlePage.dark-mode header {
                    background-image: 
                        /* Top radial gradient */
                        radial-gradient(circle at bottom, rgba(7,28,48,0) 0%, rgba(12,12,22,0.4) 70%, rgba(12,12,22,0.94) 100%),
                        /* Grid */
                        linear-gradient(rgba(27,26,30,0.32) 0%, rgba(27,26,30,0.32) 100%),
                        /* Bottom background */
                        url({{ $feature_image_large_url }});
                    background-size: 
                        100%,
                        100%,
                        cover;
                }
            }
        </style>
    @endpush