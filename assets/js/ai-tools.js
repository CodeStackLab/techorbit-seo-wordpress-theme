/**
 * AI Tools JS — TechOrbit SEO Theme
 * Handles all AI tool AJAX calls, output rendering, and copy logic
 */

(function () {
    'use strict';

    /* ---- MAIN CALL FUNCTION ---- */
    window.callAI = async function (toolName, userInput, userInput2) {
        const loadingEl = document.getElementById('loading');
        const outputEl = document.getElementById('tool-output');
        const errorEl = document.getElementById('tool-error');
        const submitBtn = document.getElementById('tool-submit-btn');
        const vars = typeof techorbit_vars !== 'undefined' ? techorbit_vars : {};

        if (!userInput || !userInput.trim()) {
            showError(errorEl, vars.strings?.enter_input || 'Please enter some input.');
            return;
        }

        // Show loading
        hideElement(outputEl);
        hideElement(errorEl);
        showElement(loadingEl, 'flex');
        if (submitBtn) { submitBtn.disabled = true; }

        const formData = new FormData();
        formData.append('action', 'techorbit_ai_call');
        formData.append('nonce', vars.nonce || '');
        formData.append('tool', toolName);
        formData.append('input', userInput.trim());
        if (userInput2) formData.append('input2', userInput2.trim());

        try {
            const response = await fetch(vars.ajax_url || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
            });

            if (!response.ok) {
                throw new Error('Network response was not ok (' + response.status + ')');
            }

            const data = await response.json();

            if (data.success) {
                renderOutput(toolName, data.data.result, outputEl);
                showElement(outputEl);
            } else {
                const msg = data.data?.message || 'An error occurred. Please try again.';
                showError(errorEl, msg);
            }
        } catch (err) {
            showError(errorEl, vars.strings?.error_generic || 'Connection error. Please try again.');
            console.error('[TechOrbit AI]', err);
        } finally {
            hideElement(loadingEl);
            if (submitBtn) { submitBtn.disabled = false; }
        }
    };

    /* ---- OUTPUT RENDERER ---- */
    function renderOutput(toolName, result, outputEl) {
        const contentEl = outputEl.querySelector('#output-content');
        if (!contentEl) return;

        let html = '';

        switch (toolName) {
            case 'meta-generator':
                html = renderMetaOutput(result);
                break;
            case 'keyword-cluster':
                html = renderClusterOutput(result);
                break;
            case 'faq-generator':
                html = renderFaqOutput(result);
                break;
            case 'blog-outline':
                html = renderOutlineOutput(result);
                break;
            case 'product-desc':
                html = renderProductOutput(result);
                break;
            default:
                html = '<pre style="white-space:pre-wrap;">' + escapeHtml(result) + '</pre>';
        }

        contentEl.innerHTML = html;

        // Store raw result for copy
        outputEl.dataset.rawResult = result;
    }

    /* ---- META GENERATOR ---- */
    function renderMetaOutput(result) {
        let data = null;
        try {
            const cleaned = result.replace(/```json\n?/g, '').replace(/```\n?/g, '').trim();
            data = JSON.parse(cleaned);
        } catch (e) { }

        if (!data || (!data.title && !data.description)) {
            return '<pre style="white-space:pre-wrap;">' + escapeHtml(result) + '</pre>';
        }

        const titleLen = (data.title || '').length;
        const descLen = (data.description || '').length;

        return `
      <div class="meta-result-wrap">
        <div class="meta-field">
          <div class="meta-field-label">
            SEO Title
            <span class="char-badge ${titleLen > 60 ? 'over' : ''}">${titleLen}/60 chars</span>
          </div>
          <div class="meta-field-value">${escapeHtml(data.title || '')}</div>
        </div>
        <div class="meta-field">
          <div class="meta-field-label">
            Meta Description
            <span class="char-badge ${descLen > 160 ? 'over' : ''}">${descLen}/160 chars</span>
          </div>
          <div class="meta-field-value">${escapeHtml(data.description || '')}</div>
        </div>
        <div style="margin-top:16px;padding:16px;background:#F0FDF4;border-radius:8px;border:1px solid #BBF7D0;">
          <div style="font-size:12px;font-weight:700;color:#065F46;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px;">Google SERP Preview</div>
          <div style="font-size:18px;color:#1A0DAB;text-decoration:underline;margin-bottom:4px;line-height:1.3;">${escapeHtml(data.title || '')}</div>
          <div style="font-size:13px;color:#4D5156;line-height:1.5;">${escapeHtml(data.description || '')}</div>
        </div>
      </div>
    `;
    }

    /* ---- KEYWORD CLUSTER ---- */
    function renderClusterOutput(result) {
        let data = null;
        try {
            const cleaned = result.replace(/```json\n?/g, '').replace(/```\n?/g, '').trim();
            data = JSON.parse(cleaned);
        } catch (e) { }

        if (!Array.isArray(data)) {
            return '<pre style="white-space:pre-wrap;">' + escapeHtml(result) + '</pre>';
        }

        const intentMap = {
            informational: 'intent-informational',
            commercial: 'intent-commercial',
            transactional: 'intent-transactional',
            navigational: 'intent-navigational',
        };

        const cards = data.map(function (cluster) {
            const intentClass = intentMap[cluster.intent?.toLowerCase()] || 'intent-informational';
            const keywords = Array.isArray(cluster.keywords) ? cluster.keywords : [];

            return `
        <div class="cluster-card">
          <div class="cluster-card-header">
            <span class="cluster-name">📂 ${escapeHtml(cluster.cluster || '')}</span>
            <span class="cluster-intent ${intentClass}">${escapeHtml(cluster.intent || '')}</span>
          </div>
          <div class="cluster-keywords">
            ${keywords.map(function (kw) {
                return '<span class="keyword-tag">🔑 ' + escapeHtml(kw) + '</span>';
            }).join('')}
          </div>
        </div>
      `;
        }).join('');

        return '<div class="cluster-cards">' + cards + '</div>';
    }

    /* ---- FAQ GENERATOR ---- */
    function renderFaqOutput(result) {
        // The output is a JSON-LD script tag — display raw in a code block
        const cleaned = result.trim();
        return `
      <div>
        <p style="font-size:13px;color:var(--text-muted);margin-bottom:12px;">📋 Copy the code below and paste it into your page's HTML &lt;head&gt; or before &lt;/body&gt;:</p>
        <pre style="background:#0F172A;color:#E2E8F0;padding:20px;border-radius:8px;overflow-x:auto;font-family:'JetBrains Mono',monospace;font-size:12px;line-height:1.7;white-space:pre-wrap;">${escapeHtml(cleaned)}</pre>
      </div>
    `;
    }

    /* ---- BLOG OUTLINE ---- */
    function renderOutlineOutput(result) {
        const lines = result.split('\n');
        let html = '<div class="outline-content">';
        lines.forEach(function (line) {
            const escaped = escapeHtml(line);
            if (line.startsWith('# ') || line.match(/^H1:/i)) {
                html += '<div style="font-size:18px;font-weight:800;color:#1A1A2E;margin:8px 0 4px;">' + escaped + '</div>';
            } else if (line.startsWith('## ') || line.match(/^H2:/i)) {
                html += '<div style="font-size:15px;font-weight:700;color:#FF6B00;margin:10px 0 4px;padding-left:16px;">' + escaped + '</div>';
            } else if (line.startsWith('### ') || line.match(/^H3:/i)) {
                html += '<div style="font-size:14px;font-weight:600;color:#374151;margin:4px 0;padding-left:32px;">' + escaped + '</div>';
            } else if (line.startsWith('#### ') || line.match(/^H4:/i)) {
                html += '<div style="font-size:13px;color:#4B5563;margin:2px 0;padding-left:48px;">' + escaped + '</div>';
            } else if (line.trim() === '') {
                html += '<br>';
            } else {
                html += '<div style="font-size:14px;color:#4B5563;padding-left:16px;margin:2px 0;">' + escaped + '</div>';
            }
        });
        html += '</div>';
        return html;
    }

    /* ---- PRODUCT DESCRIPTION ---- */
    function renderProductOutput(result) {
        const paragraphs = result.split('\n\n').filter(Boolean);
        const html = paragraphs.map(function (p) {
            return '<p style="font-size:15px;line-height:1.8;color:#374151;margin-bottom:16px;">' + escapeHtml(p.trim()) + '</p>';
        }).join('');
        return html || '<p>' + escapeHtml(result) + '</p>';
    }

    /* ---- COPY BUTTON ---- */
    window.copyResult = function (btn) {
        const outputEl = document.getElementById('tool-output');
        const rawResult = outputEl ? outputEl.dataset.rawResult : '';
        if (rawResult) {
            techorbitCopy(rawResult, btn || document.querySelector('.btn-copy'));
        }
    };

    /* ---- HELPERS ---- */
    function showElement(el, display) {
        if (el) el.style.display = display || 'block';
    }

    function hideElement(el) {
        if (el) el.style.display = 'none';
    }

    function showError(el, message) {
        if (!el) return;
        el.textContent = '⚠️ ' + message;
        el.classList.add('visible');
    }

    function escapeHtml(str) {
        if (typeof str !== 'string') return '';
        return str
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    /* ---- FORM SUBMIT BINDERS ---- */
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('ai-tool-form');
        if (!form) return;

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const toolName = form.dataset.tool || '';
            const inputEl = form.querySelector('[name="tool_input"]');
            const input2El = form.querySelector('[name="tool_input2"]');
            const userInput = inputEl ? inputEl.value : '';
            const userInput2 = input2El ? input2El.value : '';

            callAI(toolName, userInput, userInput2);
        });

        // Character counter
        const inputEl = form.querySelector('[name="tool_input"]');
        const counter = document.getElementById('char-counter');
        if (inputEl && counter) {
            inputEl.addEventListener('input', function () {
                counter.textContent = inputEl.value.length + ' characters';
            });
        }
    });

})();
