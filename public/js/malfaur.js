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

    /* ── Dynamic Multi-Level Category & Product Filtering Engine ── */
    const filterBtns = document.querySelectorAll('.filter-btn');
    const productCards = document.querySelectorAll('.product-card');
    const searchInput = document.getElementById('product-search');
    const filterClear = document.getElementById('filter-clear');
    const productsCount = document.getElementById('products-count');
    const subcatFilterWrapper = document.getElementById('subcatFilterWrapper');
    const subcatPillsContainer = document.getElementById('subcatPillsContainer');

    // Dynamic categories tree passed from Blade
    const categoryTree = window.MALFAUR_CATEGORIES || [];

    let activeCategory = 'all'; // Root category name (e.g. 'Raw Materials' or 'all')
    let activeCategoryId = null; // Root or active category ID
    let activeSubcatId = null;   // Selected Subcategory ID (Level 2/3/4) or null
    let activeSubcatName = null; // Selected Subcategory Name or null
    let activeSlug = null;       // Filter by product slug if clicked from nav
    let searchQuery = '';

    // Helper: Find category node by ID or slug in tree recursively
    function findCategoryInTree(tree, matchFn) {
        if (!tree || !tree.length) return null;
        for (let i = 0; i < tree.length; i++) {
            const node = tree[i];
            if (matchFn(node)) return { node: node, root: node, parent: null };
            if (node.children && node.children.length) {
                const found = findCategoryInChildren(node.children, matchFn, node, node);
                if (found) return found;
            }
        }
        return null;
    }

    function findCategoryInChildren(children, matchFn, parentNode, rootNode) {
        for (let i = 0; i < children.length; i++) {
            const child = children[i];
            if (matchFn(child)) return { node: child, root: rootNode, parent: parentNode };
            if (child.children && child.children.length) {
                const found = findCategoryInChildren(child.children, matchFn, child, rootNode);
                if (found) return found;
            }
        }
        return null;
    }

    // Helper: Find root category object by Name or Slug
    function findRootCategory(nameOrSlug) {
        if (!nameOrSlug || nameOrSlug === 'all') return null;
        const lower = nameOrSlug.toLowerCase();
        return categoryTree.find(function (cat) {
            return (cat.name && cat.name.toLowerCase() === lower) || (cat.slug && cat.slug.toLowerCase() === lower);
        }) || null;
    }

    // Helper: Get card category IDs array
    function getCardCategoryIds(card) {
        try {
            const raw = card.getAttribute('data-category-ids');
            if (raw) {
                const parsed = JSON.parse(raw);
                if (Array.isArray(parsed)) return parsed.map(Number);
            }
        } catch (e) {}
        return [];
    }

    // Helper: Count matching products for given category ID(s)
    function countProductsForCategory(rootName, idsArray) {
        let count = 0;
        productCards.forEach(function (card) {
            const cardRoot = (card.getAttribute('data-root-category') || card.getAttribute('data-category') || '').toLowerCase();
            const cardIds = getCardCategoryIds(card);

            if (rootName && rootName.toLowerCase() !== 'all') {
                const rootMatches = (cardRoot === rootName.toLowerCase()) || (idsArray && idsArray.some(function (id) { return cardIds.includes(Number(id)); }));
                if (!rootMatches) return;
            }

            if (!idsArray || idsArray.length === 0) {
                count++;
                return;
            }

            const matches = idsArray.some(function (id) {
                return cardIds.includes(Number(id));
            });

            if (matches) {
                count++;
            }
        });
        return count;
    }

    function syncUrlState() {
        try {
            const url = new URL(window.location.href);
            if (activeCategoryId) {
                url.searchParams.set('category_id', activeCategoryId);
            } else {
                url.searchParams.delete('category_id');
            }

            if (activeCategory && activeCategory !== 'all') {
                url.searchParams.set('category', activeCategory);
            } else {
                url.searchParams.delete('category');
            }

            if (activeSubcatId) {
                url.searchParams.set('subcat', activeSubcatId);
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
        } catch (e) {}
    }

    function renderSubcatPills() {
        if (!subcatFilterWrapper || !subcatPillsContainer) return;

        const currentRoot = findRootCategory(activeCategory);

        if (!currentRoot || activeCategory === 'all' || !currentRoot.children || currentRoot.children.length === 0) {
            subcatFilterWrapper.style.display = 'none';
            subcatPillsContainer.innerHTML = '';
            return;
        }

        subcatPillsContainer.innerHTML = '';

        // 1. "All [Root Category]" pill
        const rootTotalCount = countProductsForCategory(currentRoot.name, currentRoot.all_ids || [currentRoot.id]);
        const allBtn = document.createElement('button');
        allBtn.type = 'button';
        allBtn.className = 'subcat-pill-btn' + (activeSubcatId === null ? ' active' : '');
        allBtn.setAttribute('data-subcat-id', 'all');
        allBtn.innerHTML = `<span>All ${currentRoot.name}</span><span class="subcat-count">${rootTotalCount}</span>`;

        allBtn.addEventListener('click', function () {
            subcatPillsContainer.querySelectorAll('.subcat-pill-btn').forEach(function (b) { b.classList.remove('active'); });
            allBtn.classList.add('active');
            activeSubcatId = null;
            activeSubcatName = null;
            activeSlug = null;
            syncUrlState();
            updateDisplay();
        });
        subcatPillsContainer.appendChild(allBtn);

        // 2. Child Level 2 subcategories
        currentRoot.children.forEach(function (sub) {
            const subIds = sub.all_ids && sub.all_ids.length ? sub.all_ids : [sub.id];
            const subCount = countProductsForCategory(currentRoot.name, subIds);

            const btn = document.createElement('button');
            btn.type = 'button';
            const isSubActive = activeSubcatId !== null && (Number(activeSubcatId) === Number(sub.id) || (sub.all_ids && sub.all_ids.includes(Number(activeSubcatId))));
            btn.className = 'subcat-pill-btn' + (isSubActive ? ' active' : '');
            btn.setAttribute('data-subcat-id', sub.id);
            btn.innerHTML = `<span>${sub.name}</span><span class="subcat-count">${subCount}</span>`;

            btn.addEventListener('click', function () {
                subcatPillsContainer.querySelectorAll('.subcat-pill-btn').forEach(function (b) { b.classList.remove('active'); });
                btn.classList.add('active');
                activeSubcatId = sub.id;
                activeSubcatName = sub.name;
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
        const currentRoot = findRootCategory(activeCategory);

        productCards.forEach(function (card) {
            const cardRoot = (card.getAttribute('data-root-category') || card.getAttribute('data-category') || '').toLowerCase();
            const cardName = (card.getAttribute('data-name') || '').toLowerCase();
            const cardDesc = (card.getAttribute('data-desc') || '').toLowerCase();
            const cardCatName = (card.getAttribute('data-category-name') || '').toLowerCase();
            const cardSlug = (card.getAttribute('data-slug') || '').toLowerCase();
            const cardIds = getCardCategoryIds(card);

            // 1. Root Category Match
            let matchCat = true;
            if (activeCategory !== 'all') {
                if (currentRoot && currentRoot.all_ids && currentRoot.all_ids.length > 0) {
                    matchCat = currentRoot.all_ids.some(function (id) { return cardIds.includes(Number(id)); }) || (cardRoot === activeCategory.toLowerCase());
                } else {
                    matchCat = (cardRoot === activeCategory.toLowerCase());
                }
            }

            // 2. Subcategory Match
            let matchSubcat = true;
            if (activeSubcatId !== null) {
                const foundSub = findCategoryInTree(categoryTree, function (c) {
                    return Number(c.id) === Number(activeSubcatId) || c.slug === String(activeSubcatId);
                });

                if (foundSub && foundSub.node) {
                    const targetIds = foundSub.node.all_ids && foundSub.node.all_ids.length ? foundSub.node.all_ids : [foundSub.node.id];
                    matchSubcat = targetIds.some(function (id) { return cardIds.includes(Number(id)); }) || cardCatName.includes(foundSub.node.name.toLowerCase());
                } else {
                    matchSubcat = cardIds.includes(Number(activeSubcatId));
                }
            }

            // 3. Slug Match
            let matchSlug = true;
            if (activeSlug) {
                matchSlug = (cardSlug === activeSlug.toLowerCase()) || cardSlug.startsWith(activeSlug.toLowerCase());
            }

            // 4. Search Query Match
            let matchSearch = true;
            if (searchQuery !== '') {
                const searchTerms = searchQuery.split(/\s+/).filter(Boolean);
                matchSearch = searchTerms.length === 0 || searchTerms.every(function (term) {
                    return cardName.includes(term) || cardDesc.includes(term) || cardCatName.includes(term) || cardRoot.includes(term);
                });
            }

            if (matchCat && matchSubcat && matchSlug && matchSearch) {
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
            if (activeSubcatName) {
                activeCatLabel.textContent = activeCategory + ' › ' + activeSubcatName;
            } else {
                activeCatLabel.textContent = (activeCategory === 'all') ? 'All Categories' : activeCategory;
            }
        }

        if (productsCount) {
            let label = visible + ' precision product' + (visible !== 1 ? 's' : '') + ' found';
            if (searchQuery) {
                label += ' for "' + searchQuery + '"';
            } else if (activeSubcatName) {
                label += ' in ' + activeSubcatName;
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
                activeCategory = btn.getAttribute('data-filter') || 'all';
                const catIdAttr = btn.getAttribute('data-cat-id');
                activeCategoryId = (catIdAttr && catIdAttr !== 'all') ? Number(catIdAttr) : null;
                activeSubcatId = null;
                activeSubcatName = null;
                activeSlug = null;
                if (searchInput && searchInput.placeholder.startsWith('Showing:')) {
                    searchInput.placeholder = 'Search by name, spec, or standard (e.g. Hex Bar, Caliper, Reamer)...';
                }
                renderSubcatPills();
                syncUrlState();
                updateDisplay();
            });
        });

        // Parse URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const catIdParam = urlParams.get('category_id');
        const catQueryParam = urlParams.get('category');
        const subcatQueryParam = urlParams.get('subcat');
        const slugQueryParam = urlParams.get('slug');
        const searchQueryParam = urlParams.get('search');

        // Priority 1: category_id provided (could be root or child category)
        if (catIdParam) {
            const foundCat = findCategoryInTree(categoryTree, function (c) {
                return Number(c.id) === Number(catIdParam) || c.slug === String(catIdParam);
            });

            if (foundCat) {
                const rootNode = foundCat.root;
                const targetNode = foundCat.node;

                activeCategory = rootNode.name;
                activeCategoryId = rootNode.id;

                // Highlight corresponding root button
                filterBtns.forEach(function (b) {
                    const bName = (b.getAttribute('data-filter') || '').toLowerCase();
                    const bId = b.getAttribute('data-cat-id');
                    b.classList.toggle('active', bName === rootNode.name.toLowerCase() || (bId && Number(bId) === Number(rootNode.id)));
                });

                if (targetNode.id !== rootNode.id) {
                    activeSubcatId = targetNode.id;
                    activeSubcatName = targetNode.name;
                }
            }
        } else if (catQueryParam) {
            // Priority 2: category string provided
            const matchedBtn = Array.from(filterBtns).find(function (b) {
                return (b.getAttribute('data-filter') || '').toLowerCase() === catQueryParam.toLowerCase() || (b.getAttribute('data-cat-slug') || '').toLowerCase() === catQueryParam.toLowerCase();
            });

            if (matchedBtn) {
                filterBtns.forEach(function (b) { b.classList.remove('active'); });
                matchedBtn.classList.add('active');
                activeCategory = matchedBtn.getAttribute('data-filter');
                const catIdAttr = matchedBtn.getAttribute('data-cat-id');
                activeCategoryId = (catIdAttr && catIdAttr !== 'all') ? Number(catIdAttr) : null;
            }
        }

        if (subcatQueryParam && !activeSubcatId) {
            const foundSub = findCategoryInTree(categoryTree, function (c) {
                return Number(c.id) === Number(subcatQueryParam) || c.slug === String(subcatQueryParam);
            });
            if (foundSub) {
                activeSubcatId = foundSub.node.id;
                activeSubcatName = foundSub.node.name;
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
        updateDisplay();
    }

    const searchClearBtn = document.getElementById('search-clear-btn');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            searchQuery = searchInput.value.trim().toLowerCase();
            activeSubcatId = null;
            activeSubcatName = null;
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
        activeCategoryId = null;
        activeSubcatId = null;
        activeSubcatName = null;
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
                activeCategoryId = null;
                activeSubcatId = null;
                activeSubcatName = null;
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
