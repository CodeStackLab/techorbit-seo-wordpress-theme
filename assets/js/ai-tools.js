(function () {
    'use strict';

    /* ---- KEYWORD CLUSTER (Elite Version) ---- */
    function renderClusterOutput(data) {
        if (!Array.isArray(data)) return renderMarkdown(typeof data === 'string' ? data : JSON.stringify(data));
        return `
            <div class="cluster-strategy-grid">
                ${data.map((cluster) => `
                    <div class="cluster-card">
                        <div class="cluster-card-head">
                            <span class="cluster-badge">${escapeHtml(cluster.intent || 'SEO Intent')}</span>
                            <h4>${escapeHtml(cluster.cluster)}</h4>
                        </div>
                        <div class="cluster-strategy">${renderMarkdown(cluster.strategy || 'Growth Strategy')}</div>
                        <div class="cluster-keywords-list">
                            ${(cluster.keywords || []).map(k => `<span class="k-tag">${escapeHtml(k)}</span>`).join('')}
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
    }

    /* ---- META GENERATOR (Google Preview Style) ---- */
    function renderMetaOutput(data) {
        const options = data.options || [];
        if (!options.length) return renderMarkdown(JSON.stringify(data));
        const opt = options[0]; // Show only the best one

        return `
            <div class="meta-preview-wrap">
                <div class="preview-label">Google Search Preview</div>
                <div class="google-preview-card">
                    <div class="preview-header">
                        <div class="preview-site-icon">G</div>
                        <div class="preview-site-info">
                            <span class="site-name">TechOrbit SEO</span>
                            <span class="site-url">https://techorbit.xyz › ...</span>
                        </div>
                    </div>
                    <div class="preview-title">${escapeHtml(opt.title)}</div>
                    <div class="preview-description">${escapeHtml(opt.description)}</div>
                </div>

                <div class="meta-data-card">
                    <div class="meta-data-grid">
                        <div class="meta-data-item">
                            <label>Optimized Title</label>
                            <div class="data-value-row">
                                <span id="meta-title-text">${escapeHtml(opt.title)}</span>
                                <button class="copy-btn-icon" onclick="techorbitCopy('${escapeJs(opt.title)}', this)">📋</button>
                            </div>
                            <div class="char-count-meta ${opt.title.length > 60 ? 'warning' : ''}">${opt.title.length}/60 chars</div>
                        </div>
                        <div class="meta-data-item">
                            <label>Meta Description</label>
                            <div class="data-value-row">
                                <span id="meta-desc-text">${escapeHtml(opt.description)}</span>
                                <button class="copy-btn-icon" onclick="techorbitCopy('${escapeJs(opt.description)}', this)">📋</button>
                            </div>
                            <div class="char-count-meta ${opt.description.length > 160 ? 'warning' : ''}">${opt.description.length}/160 chars</div>
                        </div>
                    </div>

                    <div class="strategy-insight">
                        <strong>🎯 SEO Strategy:</strong>
                        <p>${renderMarkdown(opt.reasoning)}</p>
                    </div>
                </div>
            </div>
        `;
    }

    /* ---- BASIC MARKDOWN RENDERER ---- */
    function renderMarkdown(text) {
        if (!text) return '';

        let html = text;

        // 1. Handle Code Blocks (Triple Backticks) - Shield them from other replacements
        const codeBlocks = [];
        html = html.replace(/```(?:json|html|javascript|css|php)?\n?([\s\S]*?)\n?```/gim, (match, code) => {
            const id = `CODE_BLOCK_${codeBlocks.length}`;
            codeBlocks.push(`
                <div class="code-block-container">
                    <div class="code-block-header">
                        <span>Code Output</span>
                        <button class="btn-copy-mini" onclick="techorbit_copy_code(this)" data-code="${btoa(unescape(encodeURIComponent(code.trim())))}">
                            <img draggable="false" role="img" class="emoji" alt="📋" src="https://s.w.org/images/core/emoji/17.0.2/svg/1f4cb.svg"> Copy Code
                        </button>
                    </div>
                    <pre><code>${escapeHtml(code.trim())}</code></pre>
                </div>
            `);
            return id;
        });

        // 2. Standard Markdown Replacements
        html = html
            .replace(/^### (.*$)/gim, '<h3>$1</h3>')
            .replace(/^## (.*$)/gim, '<h2>$1</h2>')
            .replace(/^# (.*$)/gim, '<h1>$1</h1>')
            .replace(/^\> (.*$)/gim, '<blockquote>$1</blockquote>')
            .replace(/\*\*(.*)\*\*/gim, '<strong>$1</strong>')
            .replace(/\*(.*)\*/gim, '<em>$1</em>')
            .replace(/`(.*?)`/gim, '<code>$1</code>');

        // 3. Line Breaks (Skip if already handled by headers/lists or code blocks)
        html = html.split('\n').map(line => {
            if (line.match(/^(<h|<li|CODE_BLOCK_)/)) return line;
            return line + '<br>';
        }).join('\n');

        // 4. Handle Lists
        html = html.replace(/^\s*[\-\*•]\s+(.*)$/gim, '<li>$1</li>');
        if (html.includes('<li>')) {
            html = html.replace(/(<li>.*<\/li>)/gim, '<ul>$1</ul>');
            html = html.replace(/<\/ul><ul>/gim, '');
        }

        // 5. Restore Code Blocks
        codeBlocks.forEach((block, i) => {
            html = html.replace(`CODE_BLOCK_${i}`, block);
        });

        return `<div class="chatgpt-response">${html}</div>`;
    }

    /* ---- HELPER: COPY CODE FUNCTION ---- */
    window.techorbit_copy_code = function (btn) {
        const base64Code = btn.getAttribute('data-code');
        const code = decodeURIComponent(escape(atob(base64Code)));

        navigator.clipboard.writeText(code).then(() => {
            const originalText = btn.innerHTML;
            btn.innerHTML = '<img draggable="false" role="img" class="emoji" alt="✅" src="https://s.w.org/images/core/emoji/17.0.2/svg/2705.svg"> Copied!';
            btn.classList.add('copied');
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('copied');
            }, 2000);
        });
    };

    function escapeJs(str) {
        return str.replace(/'/g, "\\'").replace(/"/g, '\\"').replace(/\n/g, '\\n');
    }

    /* ---- PROGRESS SIMULATOR ---- */
    function startProgressSim() {
        const loadingEl = document.getElementById('loading');
        if (!loadingEl) return;
        let progress = 0;
        let step = 0;
        const steps = ['Analyzing search intent...', 'Accessing real-time SEO data...', 'Structuring content hierarchy...', 'Applying semantic logic...', 'Finalizing premium GUI...'];
        const textEl = loadingEl.querySelector('p:first-of-type');
        if (!loadingEl.querySelector('.progress-sim')) {
            loadingEl.insertAdjacentHTML('beforeend', '<div class="progress-sim"><div class="progress-bar"></div></div>');
        }
        const bar = loadingEl.querySelector('.progress-bar');
        const interval = setInterval(() => {
            progress += Math.floor(Math.random() * 15) + 5;
            if (progress > 95) progress = 95;
            if (bar) bar.style.width = progress + '%';
            if (progress > step * 20 && step < steps.length) {
                if (textEl) textEl.textContent = steps[step];
                step++;
            }
        }, 400);
        return interval;
    }

    window.callAI = async function (toolName, userInput, userInput2) {
        const loadingEl = document.getElementById('loading');
        const outputEl = document.getElementById('tool-output');
        const errorEl = document.getElementById('tool-error');
        const submitBtn = document.getElementById('tool-submit-btn');
        const vars = typeof techorbit_vars !== 'undefined' ? techorbit_vars : {};
        if (!userInput || !userInput.trim()) { showError(errorEl, vars.strings?.enter_input || 'Please enter some input.'); return; }
        hideElement(outputEl);
        hideElement(errorEl);
        showElement(loadingEl, 'flex');
        if (submitBtn) submitBtn.disabled = true;
        const progressInterval = startProgressSim();
        const formData = new FormData();
        formData.append('action', 'techorbit_ai_call');
        formData.append('nonce', vars.nonce || '');
        formData.append('tool', toolName);
        formData.append('input', userInput.trim());
        if (userInput2) formData.append('input2', userInput2.trim());

        try {
            console.log('[TechOrbit AI] Sending request for:', toolName);
            const response = await fetch(vars.ajax_url || '/wp-admin/admin-ajax.php', { method: 'POST', body: formData });
            const data = await response.json();
            console.log('[TechOrbit AI] Response:', data);

            if (data.success) {
                renderOutput(toolName, data.data.result, outputEl);
                showElement(outputEl);
                const bar = loadingEl.querySelector('.progress-bar');
                if (bar) bar.style.width = '100%';
            } else {
                showError(errorEl, data.data?.message || 'API Not Working.');
            }
        } catch (err) {
            console.error('[TechOrbit AI] Fetch error:', err);
            showError(errorEl, 'API Not Working. Check console for details.');
        } finally {
            clearInterval(progressInterval);
            setTimeout(() => {
                hideElement(loadingEl);
                if (submitBtn) submitBtn.disabled = false;
            }, 500);
        }
    };

    function renderOutput(toolName, result, outputEl) {
        const contentEl = outputEl.querySelector('#output-content');
        if (!contentEl) return;

        let cleanResult = result.trim();

        // Detect if it's JSON (for Keyword Cluster or legacy tools)
        const isJson = (cleanResult.startsWith('{') || cleanResult.startsWith('[')) && toolName !== 'meta-generator';

        if (isJson) {
            try {
                const jsonObj = JSON.parse(cleanResult);
                outputEl.dataset.rawResult = cleanResult;

                if (toolName === 'keyword-cluster') {
                    contentEl.innerHTML = renderClusterOutput(jsonObj);
                    return;
                }

                // Default JSON pretty-print
                contentEl.innerHTML = `<div class="premium-code-block"><code>${escapeHtml(JSON.stringify(jsonObj, null, 2))}</code></div>`;
                return;
            } catch (e) {
                console.warn('[TechOrbit AI] JSON Parse Error:', e);
            }
        }

        // Default: ChatGPT-style Markdown rendering
        contentEl.innerHTML = `
            <div class="chatgpt-response">
                ${renderMarkdown(cleanResult)}
                <div class="chat-footer-actions">
                    <button class="btn-copy-mini" onclick="copyResult(this)">
                        📋 Copy Entire Response
                    </button>
                </div>
            </div>
        `;
        outputEl.dataset.rawResult = cleanResult;
    }

    window.copyResult = (btn) => {
        const r = document.getElementById('tool-output')?.dataset.rawResult;
        if (r) {
            techorbitCopy(r, btn);
        }
    };

    function escapeHtml(s) {
        return s ? s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;') : '';
    }

    function showElement(el, d) { if (el) el.style.display = d || 'block'; }
    function hideElement(el) { if (el) el.style.display = 'none'; }
    function showError(el, m) { if (el) { el.textContent = '⚠️ ' + m; el.classList.add('visible'); } }

    document.addEventListener('DOMContentLoaded', () => {
        const f = document.getElementById('ai-tool-form');
        if (!f) return;
        f.addEventListener('submit', e => {
            e.preventDefault();
            callAI(f.dataset.tool, f.querySelector('[name="tool_input"]')?.value, f.querySelector('[name="tool_input2"]')?.value);
        });

        // Restore character counter
        const inputEl = f.querySelector('[name="tool_input"]');
        const counter = document.getElementById('char-counter');
        if (inputEl && counter) {
            inputEl.addEventListener('input', () => {
                counter.textContent = inputEl.value.length + ' characters';
            });
        }
    });

})();
