/* ============================================================
   MALFAUR ENGINEERING PRODUCTS — Main JavaScript
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {

    /* ── Sticky Header ── */
    const header = document.getElementById('site-header');
    if (header) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 40) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }, { passive: true });
    }

    /* ── Mobile Navigation ── */
    const hamburger = document.getElementById('hamburger');
    const mobileNav = document.getElementById('mobile-nav');
    if (hamburger && mobileNav) {
        hamburger.addEventListener('click', function () {
            const isOpen = mobileNav.classList.toggle('open');
            hamburger.classList.toggle('open', isOpen);
            document.body.style.overflow = isOpen ? 'hidden' : '';
        });
        // Close on link click
        mobileNav.querySelectorAll('.mobile-nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                mobileNav.classList.remove('open');
                hamburger.classList.remove('open');
                document.body.style.overflow = '';
            });
        });
        // Close on outside click
        document.addEventListener('click', function (e) {
            if (!header.contains(e.target) && mobileNav.classList.contains('open')) {
                mobileNav.classList.remove('open');
                hamburger.classList.remove('open');
                document.body.style.overflow = '';
            }
        });
    }

    /* ── 3-Way Cascading Products Mega Dropdown ── */
    const navProductsItem = document.getElementById('navProductsItem');
    const navProductsTrigger = document.getElementById('navProductsTrigger');
    const megaDropdown = document.getElementById('productsMegaDropdown');

    if (navProductsItem && megaDropdown) {
        let closeTimer = null;

        function openMegaMenu() {
            if (closeTimer) clearTimeout(closeTimer);
            megaDropdown.classList.add('is-open');
            navProductsItem.classList.add('is-open');
            if (navProductsTrigger) {
                navProductsTrigger.classList.add('menu-open');
                navProductsTrigger.setAttribute('aria-expanded', 'true');
            }
        }

        function closeMegaMenu() {
            closeTimer = setTimeout(function () {
                megaDropdown.classList.remove('is-open');
                navProductsItem.classList.remove('is-open');
                if (navProductsTrigger) {
                    navProductsTrigger.classList.remove('menu-open');
                    navProductsTrigger.setAttribute('aria-expanded', 'false');
                }
                resetToPlaceholder();
            }, 180);
        }

        // Trigger hover
        navProductsItem.addEventListener('mouseenter', openMegaMenu);
        navProductsItem.addEventListener('mouseleave', closeMegaMenu);

        // Mega dropdown hover (keep open)
        megaDropdown.addEventListener('mouseenter', function () {
            if (closeTimer) clearTimeout(closeTimer);
        });
        megaDropdown.addEventListener('mouseleave', closeMegaMenu);

        // Close on ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && megaDropdown.classList.contains('is-open')) {
                megaDropdown.classList.remove('is-open');
                navProductsItem.classList.remove('is-open');
                if (navProductsTrigger) {
                    navProductsTrigger.classList.remove('menu-open');
                    navProductsTrigger.setAttribute('aria-expanded', 'false');
                }
                resetToPlaceholder();
            }
        });

        // Close on outside click
        document.addEventListener('click', function (e) {
            if (!navProductsItem.contains(e.target) && !megaDropdown.contains(e.target)) {
                megaDropdown.classList.remove('is-open');
                navProductsItem.classList.remove('is-open');
                if (navProductsTrigger) {
                    navProductsTrigger.classList.remove('menu-open');
                    navProductsTrigger.setAttribute('aria-expanded', 'false');
                }
                resetToPlaceholder();
            }
        });

        /* ── Level 1 Category Switching & Placeholder State ── */
        const catItems = megaDropdown.querySelectorAll('.mega-cat-item');
        const subcatPanels = megaDropdown.querySelectorAll('.mega-subcat-panel');
        const leafPanels = megaDropdown.querySelectorAll('.mega-leaf-panel');
        const megaTopLink = megaDropdown.querySelector('.mega-top-link');

        function resetToPlaceholder() {
            megaDropdown.classList.add('no-category-selected');
            megaDropdown.classList.remove('has-category-selected');
            catItems.forEach(function (ci) { ci.classList.remove('active'); });
            subcatPanels.forEach(function (p) { p.classList.remove('active'); });
            leafPanels.forEach(function (p) { p.classList.remove('active'); });
        }

        // Initialize with placeholder on load
        resetToPlaceholder();

        function activateLeaf(subcatId) {
            leafPanels.forEach(function (panel) {
                if (panel.getAttribute('data-subcat') === subcatId) {
                    panel.classList.add('active');
                } else {
                    panel.classList.remove('active');
                }
            });
        }

        function activateCat(catItem) {
            const catId = catItem.getAttribute('data-cat-id');

            // Switch from placeholder to active categories
            megaDropdown.classList.remove('no-category-selected');
            megaDropdown.classList.add('has-category-selected');

            // Update Level 1 Active State
            catItems.forEach(function (ci) { ci.classList.remove('active'); });
            catItem.classList.add('active');

            // Update Level 2 Subcategory Panel
            let activePanel = null;
            subcatPanels.forEach(function (panel) {
                if (panel.getAttribute('data-cat') === catId) {
                    panel.classList.add('active');
                    activePanel = panel;
                } else {
                    panel.classList.remove('active');
                }
            });

            // Sync Level 3 with active subcategory in this panel
            if (activePanel) {
                const currentSubcat = activePanel.querySelector('.mega-subcat-item.active') || activePanel.querySelector('.mega-subcat-item');
                if (currentSubcat) {
                    currentSubcat.classList.add('active');
                    const subcatId = currentSubcat.getAttribute('data-subcat-id');
                    activateLeaf(subcatId);
                }
            }
        }

        catItems.forEach(function (catItem) {
            catItem.addEventListener('mouseenter', function () {
                activateCat(catItem);
            });
            catItem.addEventListener('click', function () {
                activateCat(catItem);
            });
            catItem.addEventListener('focus', function () {
                activateCat(catItem);
            });
        });

        if (megaTopLink) {
            megaTopLink.addEventListener('mouseenter', resetToPlaceholder);
        }

        /* ── Level 2 Subcategory Switching ── */
        const subcatItems = megaDropdown.querySelectorAll('.mega-subcat-item');

        subcatItems.forEach(function (subcatItem) {
            function activateSubcat() {
                const parentPanel = subcatItem.closest('.mega-subcat-panel');
                if (parentPanel) {
                    parentPanel.querySelectorAll('.mega-subcat-item').forEach(function (si) {
                        si.classList.remove('active');
                    });
                }
                subcatItem.classList.add('active');

                const subcatId = subcatItem.getAttribute('data-subcat-id');
                activateLeaf(subcatId);
            }

            subcatItem.addEventListener('mouseenter', activateSubcat);
            subcatItem.addEventListener('click', activateSubcat);
        });
    }

    /* ── Mobile Category Toggle ── */
    const mobileCatToggle = document.getElementById('mobileCatToggle');
    const mobileCatSublist = document.getElementById('mobileCatSublist');
    if (mobileCatToggle && mobileCatSublist) {
        mobileCatToggle.addEventListener('click', function (e) {
            e.preventDefault();
            const isOpen = mobileCatSublist.classList.toggle('open');
            mobileCatToggle.classList.toggle('open', isOpen);
            mobileCatToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    /* ── Scroll Fade Animations ── */
    const fadeEls = document.querySelectorAll('.fade-up');
    if (fadeEls.length > 0 && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        fadeEls.forEach(function (el) {
            observer.observe(el);
        });
    } else {
        fadeEls.forEach(function (el) { el.classList.add('visible'); });
    }

    /* ── Product Filtering (Products Page) ── */
    const filterBtns = document.querySelectorAll('.filter-btn');
    const productCards = document.querySelectorAll('.product-card[data-category]');
    const searchInput = document.getElementById('product-search');
    const filterClear = document.getElementById('filter-clear');
    const productsCount = document.getElementById('products-count');
    const subcatFilterWrapper = document.getElementById('subcatFilterWrapper');
    const subcatPillsContainer = document.getElementById('subcatPillsContainer');

    let activeCategory = 'all';
    let activeSubcat = null;
    let activeSlug = null;
    let searchQuery = '';

    const categorySubcatsMap = {
        'Cutting Tools': [
            { id: 'all', label: 'All Cutting Tools' },
            { id: 'reamers', label: 'Reamers & Deburring', keywords: ['reamer', 'deburr'] },
            { id: 'countersinks', label: 'Countersinks & Counterbores', keywords: ['counter', 'countersink', 'counterbore'] },
            { id: 'milling', label: 'Parting Off Blades', keywords: ['parting', 'blade', 'end mill', 'milling', 'insert'] }
        ],
        'Measuring Equipment': [
            { id: 'all', label: 'All Measuring Equipment' },
            { id: 'micrometers', label: 'Micrometers & Heads', keywords: ['micrometer', 'quantumike', 'mdh', 'outside micrometer'] },
            { id: 'inside-measuring', label: 'Inside Measuring', keywords: ['holtest', 'inside', '3-point', 'internal', 'head', 'caliper jaw'] },
            { id: 'calipers', label: 'Calipers & Height Gauges', keywords: ['caliper', 'height', 'gauge', 'vernier', 'dial', 'lh-600f'] }
        ],
        'Standard Parts': [
            { id: 'all', label: 'All Standard Parts' },
            { id: 'spring-plungers', label: 'Spring Plungers', keywords: ['spring plunger', 'plunger', 'thrust pin', 'slot and ball', 'long-lok'] },
            { id: 'indexing-plungers', label: 'Indexing Plungers', keywords: ['indexing', 'kipp', '1.4305', 'positioning'] },
            { id: 'fasteners-bearings', label: 'Fasteners & Bearings', keywords: ['bearing', 'fastener', 'bolt', 'hex', 'bushing'] }
        ],
        'Aerospace Parts': [
            { id: 'all', label: 'All Aerospace Parts' },
            { id: 'superalloys', label: 'Superalloys & High-Nickel', keywords: ['alloy c 22', 'alloy x', 'inconel', 'superalloy', 'alloy'] },
            { id: 'aero-fittings', label: 'Aviation Fittings', keywords: ['ams', 'fitting', 'thermal', 'welding', 'electrode'] },
            { id: 'aero-seals', label: 'Aerospace Fasteners & Seals', keywords: ['fastener', 'seal', 'o-ring', 'titanium', 'hydraulic'] }
        ],
        'Raw Materials': [
            { id: 'all', label: 'All Raw Materials' },
            { id: 'alloy-steels', label: 'Alloy Steels & Tubes', keywords: ['steel', 'hex bar', 'rectangle bar', 'streamline tube', 'tube'] },
            { id: 'aluminium-profiles', label: 'Aluminium Profiles & Extrusions', keywords: ['aluminum angle', 'aluminum channel', 't slot', 'angle', 'channel', 'extrusion', '6082'] },
            { id: 'sheets-plates', label: 'Sheets, Plates & Foils', keywords: ['foil', 'tread plate', 'plate', 'sheet'] }
        ]
    };

    const subcatMap = {
        'reamers': { label: 'Reamers & Deburring', keywords: ['reamer', 'deburr'] },
        'countersinks': { label: 'Countersinks & Counterbores', keywords: ['counter', 'countersink', 'counterbore'] },
        'milling': { label: 'Parting Off Blades', keywords: ['parting', 'blade', 'end mill', 'milling', 'insert'] },
        'micrometers': { label: 'Micrometers & Heads', keywords: ['micrometer', 'quantumike', 'mdh', 'outside micrometer'] },
        'inside-measuring': { label: 'Inside Measuring Instruments', keywords: ['holtest', 'inside', '3-point', 'internal', 'head', 'caliper jaw'] },
        'calipers': { label: 'Calipers & Height Gauges', keywords: ['caliper', 'height', 'gauge', 'vernier', 'dial', 'lh-600f'] },
        'spring-plungers': { label: 'Spring Plungers', keywords: ['spring plunger', 'plunger', 'thrust pin', 'slot and ball', 'long-lok'] },
        'indexing-plungers': { label: 'Indexing Plungers', keywords: ['indexing', 'kipp', '1.4305', 'positioning'] },
        'fasteners-bearings': { label: 'Fasteners & Bearings', keywords: ['bearing', 'fastener', 'bolt', 'hex', 'bushing'] },
        'superalloys': { label: 'Superalloys & High-Nickel', keywords: ['alloy c 22', 'alloy x', 'inconel', 'superalloy', 'alloy'] },
        'aero-fittings': { label: 'Aviation Fittings & Consumables', keywords: ['ams', 'fitting', 'thermal', 'welding', 'electrode'] },
        'aero-seals': { label: 'Aerospace Fasteners & Seals', keywords: ['fastener', 'seal', 'o-ring', 'titanium', 'hydraulic'] },
        'alloy-steels': { label: 'Alloy Steels & Tubes', keywords: ['steel', 'hex bar', 'rectangle bar', 'streamline tube', 'tube'] },
        'aluminium-profiles': { label: 'Aluminium Profiles & Extrusions', keywords: ['aluminum angle', 'aluminum channel', 't slot', 'angle', 'channel', 'extrusion', '6082'] },
        'sheets-plates': { label: 'Sheets, Plates & Foils', keywords: ['foil', 'tread plate', 'plate', 'sheet'] }
    };

    function countProductsForSubcat(catName, subcatObj) {
        let count = 0;
        productCards.forEach(function (card) {
            const cat = card.getAttribute('data-category') || '';
            if (cat.toLowerCase() !== catName.toLowerCase()) return;
            if (subcatObj.id === 'all') {
                count++;
                return;
            }
            const name = (card.getAttribute('data-name') || '').toLowerCase();
            const desc = (card.getAttribute('data-desc') || '').toLowerCase();
            const keywords = subcatObj.keywords || [];
            if (keywords.some(function (kw) { return name.includes(kw) || desc.includes(kw); })) {
                count++;
            }
        });
        return count;
    }

    function syncUrlState() {
        try {
            const url = new URL(window.location.href);
            if (activeCategory && activeCategory !== 'all') {
                url.searchParams.set('category', activeCategory);
            } else {
                url.searchParams.delete('category');
            }

            if (activeSubcat) {
                url.searchParams.set('subcat', activeSubcat);
            } else {
                url.searchParams.delete('subcat');
            }

            if (searchQuery) {
                url.searchParams.set('search', searchQuery);
            } else {
                url.searchParams.delete('search');
            }

            if (activeSlug) {
                url.searchParams.set('slug', activeSlug);
            } else {
                url.searchParams.delete('slug');
            }

            window.history.replaceState({}, '', url.toString());
        } catch (e) {
            // Ignore if URL object not supported
        }
    }

    function renderSubcatPills() {
        if (!subcatFilterWrapper || !subcatPillsContainer) return;

        if (activeCategory === 'all' || !categorySubcatsMap[activeCategory]) {
            subcatFilterWrapper.style.display = 'none';
            subcatPillsContainer.innerHTML = '';
            return;
        }

        const subcats = categorySubcatsMap[activeCategory];
        subcatPillsContainer.innerHTML = '';

        subcats.forEach(function (subcat) {
            const count = countProductsForSubcat(activeCategory, subcat);
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'subcat-pill-btn';
            btn.setAttribute('data-subcat-id', subcat.id);

            const isCurrentActive = (activeSubcat === null && subcat.id === 'all') || (activeSubcat === subcat.id);
            if (isCurrentActive) {
                btn.classList.add('active');
            }

            btn.innerHTML = `<span>${subcat.label}</span><span class="subcat-count">${count}</span>`;

            btn.addEventListener('click', function () {
                subcatPillsContainer.querySelectorAll('.subcat-pill-btn').forEach(function (b) {
                    b.classList.remove('active');
                });
                btn.classList.add('active');

                activeSubcat = (subcat.id === 'all') ? null : subcat.id;
                activeSlug = null;
                syncUrlState();
                updateDisplay();
            });

            subcatPillsContainer.appendChild(btn);
        });

        subcatFilterWrapper.style.display = 'block';
    }

    function updateDisplay() {
        let visible = 0;
        productCards.forEach(function (card) {
            const cat = card.getAttribute('data-category') || '';
            const name = (card.getAttribute('data-name') || '').toLowerCase();
            const desc = (card.getAttribute('data-desc') || '').toLowerCase();
            const slug = (card.getAttribute('data-slug') || '').toLowerCase();
            const matchCat = activeCategory === 'all' || cat.toLowerCase() === activeCategory.toLowerCase();

            let matchSlug = true;
            if (activeSlug) {
                matchSlug = (slug === activeSlug.toLowerCase()) || slug.startsWith(activeSlug.toLowerCase());
            }

            let matchSubcat = true;
            if (activeSubcat && subcatMap[activeSubcat]) {
                const keywords = subcatMap[activeSubcat].keywords;
                matchSubcat = keywords.some(function (kw) {
                    return name.includes(kw) || desc.includes(kw);
                });
            }

            let matchSearch = true;
            if (searchQuery !== '') {
                const searchTerms = searchQuery.split(/\s+/).filter(Boolean);
                matchSearch = searchTerms.length === 0 || searchTerms.every(function (term) {
                    return name.includes(term) || desc.includes(term) || cat.toLowerCase().includes(term);
                });
            }

            if (matchCat && matchSlug && matchSubcat && matchSearch) {
                card.style.display = '';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });

        const noResults = document.getElementById('no-results');
        if (noResults) {
            noResults.style.display = (visible === 0) ? 'block' : 'none';
        }

        const activeCatLabel = document.getElementById('active-category-label');
        if (activeCatLabel) {
            if (activeSubcat && subcatMap[activeSubcat]) {
                activeCatLabel.textContent = activeCategory + ' › ' + subcatMap[activeSubcat].label;
            } else {
                activeCatLabel.textContent = (activeCategory === 'all') ? 'All Categories' : activeCategory;
            }
        }

        if (productsCount) {
            let label = visible + ' precision product' + (visible !== 1 ? 's' : '') + ' found';
            if (searchQuery) {
                label += ' for "' + searchQuery + '"';
            } else if (activeSubcat && subcatMap[activeSubcat]) {
                label += ' in ' + subcatMap[activeSubcat].label;
            } else if (activeCategory !== 'all') {
                label += ' in ' + activeCategory;
            }
            productsCount.textContent = label;
        }
    }

    if (filterBtns.length > 0) {
        filterBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                filterBtns.forEach(function (b) { b.classList.remove('active'); });
                btn.classList.add('active');
                activeCategory = btn.getAttribute('data-filter');
                activeSubcat = null;
                activeSlug = null;
                if (searchInput && searchInput.placeholder.startsWith('Showing:')) {
                    searchInput.placeholder = 'Search by name, spec, or standard (e.g. Hex Bar, Caliper, Reamer)...';
                }
                renderSubcatPills();
                syncUrlState();
                updateDisplay();
            });
        });

        // Auto-select category & subcat & slug & search if passed in URL
        const urlParams = new URLSearchParams(window.location.search);
        const catQuery = urlParams.get('category');
        const subcatQueryParam = urlParams.get('subcat');
        const slugQueryParam = urlParams.get('slug');
        const searchQueryParam = urlParams.get('search');

        if (catQuery) {
            const matchedBtn = Array.from(filterBtns).find(function (b) {
                return b.getAttribute('data-filter').toLowerCase() === catQuery.toLowerCase();
            });
            if (matchedBtn) {
                filterBtns.forEach(function (b) { b.classList.remove('active'); });
                matchedBtn.classList.add('active');
                activeCategory = matchedBtn.getAttribute('data-filter');
            }
        }

        if (subcatQueryParam && subcatMap[subcatQueryParam]) {
            activeSubcat = subcatQueryParam;
            if (searchInput) {
                searchInput.placeholder = 'Showing: ' + subcatMap[subcatQueryParam].label;
            }
        }

        if (slugQueryParam) {
            activeSlug = slugQueryParam.trim().toLowerCase();
        }

        if (searchQueryParam) {
            searchQuery = searchQueryParam.trim().toLowerCase();
            if (searchInput) {
                searchInput.value = searchQueryParam;
            }
        }

        renderSubcatPills();
        if (catQuery || subcatQueryParam || slugQueryParam || searchQueryParam) {
            updateDisplay();
        }
    }

    const searchClearBtn = document.getElementById('search-clear-btn');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            searchQuery = searchInput.value.trim().toLowerCase();
            activeSubcat = null;
            activeSlug = null;
            if (searchClearBtn) {
                searchClearBtn.style.display = searchInput.value.length > 0 ? 'inline-flex' : 'none';
            }
            renderSubcatPills();
            syncUrlState();
            updateDisplay();
        });

        if (searchClearBtn) {
            searchClearBtn.addEventListener('click', function () {
                searchInput.value = '';
                searchQuery = '';
                searchClearBtn.style.display = 'none';
                syncUrlState();
                updateDisplay();
                searchInput.focus();
            });
        }
    }

    function resetAllFilters() {
        searchQuery = '';
        activeCategory = 'all';
        activeSubcat = null;
        activeSlug = null;
        if (searchInput) {
            searchInput.value = '';
            searchInput.placeholder = 'Search by name, spec, or standard (e.g. Hex Bar, Caliper, Reamer)...';
        }
        if (searchClearBtn) {
            searchClearBtn.style.display = 'none';
        }
        filterBtns.forEach(function (b) {
            b.classList.toggle('active', b.getAttribute('data-filter') === 'all');
        });
        renderSubcatPills();
        syncUrlState();
        updateDisplay();
    }

    if (filterClear) {
        filterClear.addEventListener('click', resetAllFilters);
    }

    const noResultsResetBtn = document.getElementById('no-results-reset-btn');
    if (noResultsResetBtn) {
        noResultsResetBtn.addEventListener('click', resetAllFilters);
    }

    document.querySelectorAll('.js-suggest-chip').forEach(function (chip) {
        chip.addEventListener('click', function () {
            const query = chip.getAttribute('data-query');
            if (query && searchInput) {
                searchInput.value = query;
                searchQuery = query.toLowerCase();
                if (searchClearBtn) searchClearBtn.style.display = 'inline-flex';
                activeCategory = 'all';
                activeSubcat = null;
                activeSlug = null;
                filterBtns.forEach(function (b) {
                    b.classList.toggle('active', b.getAttribute('data-filter') === 'all');
                });
                renderSubcatPills();
                syncUrlState();
                updateDisplay();
            }
        });
    });

    /* ── Product Modal ── */
    const modalOverlay = document.getElementById('product-modal');
    const modalClose = document.getElementById('modal-close');

    function openModal(data) {
        if (!modalOverlay) return;
        document.getElementById('modal-img').src = data.img;
        document.getElementById('modal-img').alt = data.name;
        document.getElementById('modal-category').textContent = data.category;
        document.getElementById('modal-name').textContent = data.name;
        document.getElementById('modal-desc').textContent = data.desc;
        // Specs
        const specsBody = document.getElementById('modal-specs-body');
        if (specsBody && data.specs) {
            specsBody.innerHTML = data.specs.map(function (s) {
                return '<div class="spec-row"><span class="spec-key">' + s[0] + '</span><span class="spec-val">' + s[1] + '</span></div>';
            }).join('');
        }
        modalOverlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        if (!modalOverlay) return;
        modalOverlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    if (modalClose) modalClose.addEventListener('click', closeModal);
    if (modalOverlay) {
        modalOverlay.addEventListener('click', function (e) {
            if (e.target === modalOverlay) closeModal();
        });
    }
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeModal();
    });

    // Attach to all "View Details" buttons
    document.querySelectorAll('.js-view-product').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const card = btn.closest('.product-card');
            if (!card) return;
            openModal({
                img: card.getAttribute('data-img'),
                name: card.getAttribute('data-name'),
                category: card.getAttribute('data-category'),
                desc: card.getAttribute('data-desc'),
                specs: JSON.parse(card.getAttribute('data-specs') || '[]')
            });
        });
    });

    /* ── Contact Form Handling ── */
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = contactForm.querySelector('[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Enquiry Sent';
            btn.disabled = true;
            btn.style.background = '#16a34a';
            btn.style.borderColor = '#16a34a';
            setTimeout(function () {
                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.style.background = '';
                btn.style.borderColor = '';
                contactForm.reset();
            }, 4000);
        });
    }

    /* ── Smooth anchor links ── */
    document.querySelectorAll('a[href^="#"]').forEach(function (a) {
        a.addEventListener('click', function (e) {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
});
