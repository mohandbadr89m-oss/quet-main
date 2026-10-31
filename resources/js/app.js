
document.addEventListener('DOMContentLoaded', () => {

    const messageBox = document.getElementById('favorite-message');

    // =========================================
    // Notifications
    // =========================================

    function showMessage(message) {
        if (messageBox) {
            messageBox.textContent = message;
            messageBox.classList.remove('hidden');
            return;
        }

        const notification = document.createElement('div');

        notification.textContent = message;
        notification.className =
            'fixed bottom-6 left-6 z-[150] rounded-xl border border-[#C5A15B]/50 bg-[#14251F] px-5 py-3 text-sm text-[#E8DFC9] shadow-xl';

        document.body.appendChild(notification);

        setTimeout(() => notification.remove(), 3500);
    }


    // =========================================
    // AJAX Requests
    // =========================================

    async function sendRequest(form, button, errorMessage, onSuccess) {
        if (button.disabled) return;

        button.disabled = true;
        button.classList.add('opacity-50', 'cursor-wait');

        try {
            const csrfToken = form.querySelector('input[name="_token"]')?.value;

            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message || errorMessage);
            }

            onSuccess(data);
            showMessage(data.message);

        } catch (error) {
            showMessage(error.message || errorMessage);

        } finally {
            button.disabled = false;
            button.classList.remove('opacity-50', 'cursor-wait');
        }
    }


    // =========================================
    // Favorites Panel
    // =========================================

    function updateFavoritesPanel(form) {
        const favoritesPanel = document.getElementById('profile-favorites');

        if (!favoritesPanel || !favoritesPanel.contains(form)) {
            return;
        }

        const quoteCard = form.closest('blockquote');

        if (quoteCard) {
            quoteCard.remove();
        }

        const remainingQuotes = favoritesPanel.querySelectorAll(
            'blockquote[id^="quote-"]'
        ).length;

        const favoritesTab = document.querySelector(
            '[data-profile-tab="favorites"]'
        );

        if (favoritesTab) {
            favoritesTab.textContent = `المفضلة (${remainingQuotes})`;
        }

        if (remainingQuotes === 0) {
            const emptyState = document.createElement('div');

            emptyState.className =
                'rounded-2xl border border-[#80683D]/40 bg-[#1C2B21] p-10 text-center';

            const icon = document.createElement('p');
            icon.className = 'mb-3 text-4xl';
            icon.textContent = '🔖';

            const heading = document.createElement('h3');
            heading.className = 'athar-heading text-xl';
            heading.textContent = 'لم تحفظ أي عبارة بعد';

            const description = document.createElement('p');
            description.className = 'mt-3 text-sm text-[#B6A98D]';
            description.textContent =
                'احفظ العبارات التي تعجبك لتجدها هنا لاحقًا.';

            const link = document.createElement('a');
            link.href = '/';
            link.className = 'btn-primary mt-6 inline-block';
            link.textContent = 'اكتشف العبارات';

            emptyState.append(icon, heading, description, link);
            favoritesPanel.appendChild(emptyState);
        }
    }


    // =========================================
    // Favorite Buttons
    // =========================================

    document.querySelectorAll('.favorite-form').forEach((form) => {
        const button = form.querySelector('.favorite-button');
        const icon = form.querySelector('.favorite-icon');
        const label = form.querySelector('.favorite-label');

        if (!button || !icon || !label) return;

        button.addEventListener('click', () => {
            sendRequest(form, button, 'تعذر تحديث المفضلة', (data) => {
                const isFavorite = data.is_favorite;

                button.setAttribute('aria-pressed', String(isFavorite));

                button.setAttribute(
                    'aria-label',
                    isFavorite ? 'إزالة من المفضلة' : 'إضافة للمفضلة'
                );

                icon.setAttribute(
                    'fill',
                    isFavorite ? 'currentColor' : 'none'
                );

                label.textContent = isFavorite ? 'محفوظة' : 'حفظ';

                button.classList.toggle('text-[#D6B66F]', isFavorite);
                button.classList.toggle('text-[#B6A98D]', !isFavorite);

                if (!isFavorite) {
                    updateFavoritesPanel(form);
                }
            });
        });
    });


    // =========================================
    // Like Buttons
    // =========================================

    document.querySelectorAll('.like-form').forEach((form) => {
        const button = form.querySelector('.like-button');
        const icon = form.querySelector('.like-icon');
        const count = form.querySelector('.like-count');

        if (!button || !icon || !count) return;

        button.addEventListener('click', () => {
            sendRequest(form, button, 'تعذر تحديث الإعجاب', (data) => {
                const isLiked = data.is_liked;

                button.setAttribute('aria-pressed', String(isLiked));

                button.setAttribute(
                    'aria-label',
                    isLiked ? 'إلغاء الإعجاب' : 'إعجاب بالعبارة'
                );

                icon.textContent = isLiked ? '❤️' : '🤍';

                count.textContent =
                    Number(data.likes_count).toLocaleString('en-US');
            });
        });
    });


    // =========================================
    // ATHAR — Quote Image Generator
    // =========================================

    function drawWrappedText(ctx, text, x, y, maxWidth, lineHeight) {
        const words = text.split(/\s+/);
        let line = '';
        let currentY = y;

        ctx.textAlign = 'center';
        ctx.direction = 'rtl';

        words.forEach((word) => {
            const testLine = line ? `${line} ${word}` : word;

            if (ctx.measureText(testLine).width > maxWidth && line) {
                ctx.fillText(line, x, currentY);
                line = word;
                currentY += lineHeight;
            } else {
                line = testLine;
            }
        });

        if (line) {
            ctx.fillText(line, x, currentY);
        }

        return currentY;
    }


    async function createQuoteImage(quote, author, category) {
        await document.fonts.ready;

        const canvas = document.createElement('canvas');

        canvas.width = 1080;
        canvas.height = 1350;

        const ctx = canvas.getContext('2d');

        if (!ctx) {
            throw new Error('تعذر إنشاء بطاقة المشاركة');
        }

        // Background
        const background = ctx.createLinearGradient(
            0, 0, 1080, 1350
        );

        background.addColorStop(0, '#20382C');
        background.addColorStop(0.5, '#14251F');
        background.addColorStop(1, '#0B130F');

        ctx.fillStyle = background;
        ctx.fillRect(0, 0, 1080, 1350);

        // Golden lighting
        const glow = ctx.createRadialGradient(
            540, 300, 20,
            540, 300, 700
        );

        glow.addColorStop(0, 'rgba(197,161,91,0.16)');
        glow.addColorStop(1, 'rgba(197,161,91,0)');

        ctx.fillStyle = glow;
        ctx.fillRect(0, 0, 1080, 1350);

        // Outer frame
        ctx.strokeStyle = '#C5A15B';
        ctx.lineWidth = 3;
        ctx.strokeRect(48, 48, 984, 1254);

        // Inner frame
        ctx.strokeStyle = 'rgba(197,161,91,0.35)';
        ctx.lineWidth = 1.5;
        ctx.strokeRect(65, 65, 950, 1220);

        // Diamond logo
        ctx.save();
        ctx.translate(540, 185);
        ctx.rotate(Math.PI / 4);

        ctx.strokeStyle = '#C5A15B';
        ctx.lineWidth = 4;
        ctx.strokeRect(-32, -32, 64, 64);

        ctx.strokeStyle = '#D6B66F';
        ctx.lineWidth = 2;
        ctx.strokeRect(-19, -19, 38, 38);

        ctx.restore();

        // Brand
        ctx.direction = 'ltr';
        ctx.textAlign = 'center';
        ctx.fillStyle = '#D6B66F';
        ctx.font = 'bold 66px Georgia, serif';
        ctx.fillText('ATHAR', 540, 330);

        ctx.direction = 'rtl';
        ctx.fillStyle = '#E8DFC9';
        ctx.font = '34px "Amiri", serif';
        ctx.fillText('أثر · كلمات تبقى.', 540, 395);

        // Divider
        ctx.strokeStyle = 'rgba(197,161,91,0.55)';
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(230, 455);
        ctx.lineTo(850, 455);
        ctx.stroke();

        // Category
        ctx.fillStyle = '#D6B66F';
        ctx.font = '32px "IBM Plex Sans Arabic", sans-serif';
        ctx.fillText(category || 'عام', 540, 540);

        // Quote
        ctx.fillStyle = '#F0E7D5';
        ctx.font = '52px "Amiri", serif';

        const lastLineY = drawWrappedText(
            ctx,
            `“${quote}”`,
            540,
            675,
            820,
            92
        );

        // Author divider
        const dividerY = Math.min(
            Math.max(lastLineY + 170, 950),
            1090
        );

        ctx.strokeStyle = 'rgba(197,161,91,0.4)';
        ctx.beginPath();
        ctx.moveTo(300, dividerY);
        ctx.lineTo(780, dividerY);
        ctx.stroke();

        // Author
        ctx.fillStyle = '#D6B66F';
        ctx.font = '36px "IBM Plex Sans Arabic", sans-serif';
        ctx.fillText(author, 540, dividerY + 90);

        // Footer
        ctx.fillStyle = '#A99B7D';
        ctx.font = '26px "Amiri", serif';
        ctx.fillText(
            'من ذاكرة الحضارة، إلى خلود الكلمات',
            540,
            1190
        );

        ctx.direction = 'ltr';
        ctx.font = 'bold 25px Georgia, serif';
        ctx.fillStyle = '#C5A15B';
        ctx.fillText('ATHAR', 540, 1250);

        return new Promise((resolve, reject) => {
            canvas.toBlob((blob) => {
                if (!blob) {
                    reject(new Error('تعذر إنشاء صورة المشاركة'));
                    return;
                }

                resolve(blob);
            }, 'image/png');
        });
    }


    // =========================================
    // ATHAR — Share Modal
    // =========================================

    function openShareModal(modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeShareModal(modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }


    // Download PNG
    async function downloadQuoteImage(modal) {
        const blob = await createQuoteImage(
            modal.dataset.quote || '',
            modal.dataset.author || 'ATHAR',
            modal.dataset.category || 'عام'
        );

        const imageUrl = URL.createObjectURL(blob);
        const link = document.createElement('a');

        link.href = imageUrl;
        link.download = 'ATHAR-Quote.png';

        document.body.appendChild(link);
        link.click();
        link.remove();

        setTimeout(() => URL.revokeObjectURL(imageUrl), 1000);

        showMessage('تم تنزيل بطاقة الاقتباس بنجاح');
    }


    // Native Share
    async function shareQuoteImage(modal) {
        const blob = await createQuoteImage(
            modal.dataset.quote || '',
            modal.dataset.author || 'ATHAR',
            modal.dataset.category || 'عام'
        );

        const file = new File(
            [blob],
            'ATHAR-Quote.png',
            { type: 'image/png' }
        );

        if (
            navigator.share &&
            navigator.canShare &&
            navigator.canShare({ files: [file] })
        ) {
            await navigator.share({
                files: [file],
                title: 'ATHAR — أثر',
                text: 'كلمات تبقى.'
            });

            showMessage('تم تجهيز بطاقة المشاركة');

        } else {
            await downloadQuoteImage(modal);

            showMessage(
                'المشاركة غير مدعومة في هذا المتصفح، تم تنزيل الصورة بدلًا منها'
            );
        }
    }


    // Open Share Modal
    document.querySelectorAll('.share-quote-button').forEach((button) => {
        button.addEventListener('click', () => {
            const modalId = button.dataset.modalTarget;
            const modal = document.getElementById(modalId);

            if (modal) {
                openShareModal(modal);
            }
        });
    });


    // Close Share Modal
    document.querySelectorAll('.share-options-modal').forEach((modal) => {

        modal.querySelectorAll(
            '.share-modal-close, .share-modal-backdrop'
        ).forEach((button) => {
            button.addEventListener('click', () => {
                closeShareModal(modal);
            });
        });


        // Download / Share Actions
        modal.querySelectorAll('[data-share-action]').forEach((button) => {

            button.addEventListener('click', async () => {
                if (button.disabled) return;

                button.disabled = true;
                button.classList.add('opacity-50', 'cursor-wait');

                try {
                    const action = button.dataset.shareAction;

                    if (action === 'download') {
                        await downloadQuoteImage(modal);
                        closeShareModal(modal);
                    }

                    if (action === 'share') {
                        await shareQuoteImage(modal);
                        closeShareModal(modal);
                    }

                } catch (error) {
                    if (error.name !== 'AbortError') {
                        showMessage(
                            error.message || 'تعذر تنفيذ المشاركة'
                        );
                    }

                } finally {
                    button.disabled = false;
                    button.classList.remove('opacity-50', 'cursor-wait');
                }
            });

        });

    });


    // Close Share Modal with Escape
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            document.querySelectorAll('.share-options-modal').forEach((modal) => {
                if (!modal.classList.contains('hidden')) {
                    closeShareModal(modal);
                }
            });
        }
    });


    // =========================================
    // ATHAR — Museum Cinematic Intro
    // =========================================

    const museumIntro = document.getElementById('museum-intro');
    const museumContent = document.getElementById('museum-content');
    const skipIntroButton = document.getElementById('skip-museum-intro');

    if (museumIntro && museumContent) {

        let introFinished = false;
        let introTimer;

        function finishMuseumIntro() {
            if (introFinished) return;

            introFinished = true;

            clearTimeout(introTimer);

            museumIntro.classList.add('opacity-0');

            museumContent.classList.remove('opacity-0');
            museumContent.classList.add('opacity-100');

            setTimeout(() => {
                museumIntro.classList.add('hidden');
            }, 1000);
        }

        // Automatically finish the intro after 3 seconds.
        introTimer = setTimeout(finishMuseumIntro, 3000);

        // Skip intro.
        skipIntroButton?.addEventListener('click', finishMuseumIntro);
    }


    // =========================================
    // ATHAR — Museum Quote Details
    // =========================================

    const museumDetails = document.getElementById('museum-details');

    if (museumDetails) {

        const detailQuote = document.getElementById('museum-detail-quote');
        const detailAuthor = document.getElementById('museum-detail-author');
        const detailLikes = document.getElementById('museum-detail-likes');
        const detailRank = document.getElementById('museum-detail-rank');
        const closeDetailsButton = document.getElementById('close-museum-details');

        function openMuseumDetails(piece) {

            detailQuote.textContent = piece.dataset.quote || '';
            detailAuthor.textContent = piece.dataset.author || 'كاتب مجهول';

            detailLikes.textContent =
                `♥ ${piece.dataset.likes || 0} إعجاب`;

            detailRank.textContent =
                `المرتبة ${piece.dataset.rank || ''} في المتحف`;

            museumDetails.classList.remove('hidden');
            museumDetails.classList.add('flex');

            document.body.classList.add('overflow-hidden');
        }

        function closeMuseumDetails() {

            museumDetails.classList.add('hidden');
            museumDetails.classList.remove('flex');

            document.body.classList.remove('overflow-hidden');
        }

        // Open quote details.
        document.querySelectorAll('[data-museum-quote]').forEach((piece) => {

            piece.addEventListener('click', () => {
                openMuseumDetails(piece);
            });

        });

        // Close button.
        closeDetailsButton?.addEventListener('click', closeMuseumDetails);

        // Close when clicking outside the details card.
        museumDetails.addEventListener('click', (event) => {

            if (event.target === museumDetails) {
                closeMuseumDetails();
            }

        });

        // Close with Escape.
        document.addEventListener('keydown', (event) => {

            if (
                event.key === 'Escape' &&
                !museumDetails.classList.contains('hidden')
            ) {
                closeMuseumDetails();
            }

        });
    }

});
