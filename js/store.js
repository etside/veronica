/**
 * Veronica Store — localStorage data layer
 * Mirrors luxe-cotton's Product / Order / Cart models for static deployment.
 */
const DB = {
  _k: (n) => `veronica_${n}`,
  _get(n) { try { return JSON.parse(localStorage.getItem(this._k(n))) || null; } catch { return null; } },
  _set(n, v) { localStorage.setItem(this._k(n), JSON.stringify(v)); },

  /* ── Products ── */
  products() { return this._get('products') || []; },
  saveProducts(p) { this._set('products', p); },
  getProduct(slug) { return this.products().find(p => p.slug === slug); },
  addProduct(p) {
    const all = this.products();
    p.id = p.id || crypto.randomUUID();
    p.createdAt = p.createdAt || new Date().toISOString();
    all.push(p);
    this.saveProducts(all);
    return p;
  },
  updateProduct(id, patch) {
    const all = this.products();
    const idx = all.findIndex(p => p.id === id);
    if (idx < 0) return null;
    all[idx] = { ...all[idx], ...patch, updatedAt: new Date().toISOString() };
    this.saveProducts(all);
    return all[idx];
  },
  deleteProduct(id) {
    this.saveProducts(this.products().filter(p => p.id !== id));
  },

  /* ── Categories ── */
  categories() { return this._get('categories') || ['All Products', 'New Arrivals', 'Best Sellers', 'Sale', 'Collections']; },
  saveCategories(c) { this._set('categories', c); },

  /* ── Orders ── */
  orders() { return this._get('orders') || []; },
  saveOrders(o) { this._set('orders', o); },
  addOrder(order) {
    const all = this.orders();
    order.id = order.id || 'ORD-' + Date.now().toString(36).toUpperCase();
    order.createdAt = new Date().toISOString();
    order.status = order.status || 'pending';
    all.push(order);
    this.saveOrders(all);
    return order;
  },
  updateOrder(id, patch) {
    const all = this.orders();
    const idx = all.findIndex(o => o.id === id);
    if (idx < 0) return null;
    all[idx] = { ...all[idx], ...patch };
    this.saveOrders(all);
    return all[idx];
  },

  /* ── Cart ── */
  cart() { return this._get('cart') || []; },
  saveCart(c) { this._set('cart', c); },
  addToCart(item) {
    const c = this.cart();
    const exists = c.find(i => i.productId === item.productId && i.size === item.size);
    if (exists) { exists.qty += item.qty || 1; }
    else { c.push({ ...item, qty: item.qty || 1 }); }
    this.saveCart(c);
    return c;
  },
  updateCartItem(productId, size, qty) {
    const c = this.cart();
    const idx = c.findIndex(i => i.productId === productId && i.size === size);
    if (idx < 0) return;
    if (qty <= 0) c.splice(idx, 1);
    else c[idx].qty = qty;
    this.saveCart(c);
  },
  clearCart() { this.saveCart([]); },
  cartCount() { return this.cart().reduce((s, i) => s + i.qty, 0); },
  cartTotal() {
    return this.cart().reduce((s, i) => {
      const p = this.getProduct(i.productId);
      return s + (p ? p.price * i.qty : 0);
    }, 0);
  },

  /* ── Settings ── */
  settings() {
    return this._get('settings') || {
      storeName: 'VERONICA',
      currency: 'USD',
      currencySymbol: '$',
      shippingFreeThreshold: 100,
      shippingCost: 9.99,
      taxRate: 0,
      whatsapp: '',
      email: 'support@veronica.com',
      announcementText: 'NEW COLLECTION | SHOP NOW | FREE Shipping Worldwide on orders above $100+',
      heroSlides: [],
    };
  },
  saveSettings(s) { this._set('settings', s); },

  /* ── Seed demo data ── */
  seed() {
    if (this.products().length > 0) return;
    const demos = [
      { slug: 'gentle', name: 'GENTLE', price: 82.50, originalPrice: 91.67, discount: 10, image: 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=500&q=80', category: 'Best Sellers', sizes: ['XS','S','M','L','XL'], description: 'Elegant pret dress with delicate embroidery and a flattering silhouette.', stock: 25, badge: '-10%' },
      { slug: 'endless', name: 'ENDLESS', price: 82.50, originalPrice: 91.67, discount: 10, image: 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=500&q=80', category: 'Best Sellers', sizes: ['XS','S','M','L','XL'], description: 'Timeless design with modern tailoring for effortless elegance.', stock: 18, badge: '-10%' },
      { slug: 'core', name: 'CORE', price: 71.25, originalPrice: 83.83, discount: 15, image: 'https://images.unsplash.com/photo-1612336307429-8a898d10e223?w=500&q=80', category: 'Best Sellers', sizes: ['S','M','L','XL'], description: 'The essential wardrobe piece — clean lines, premium fabric.', stock: 30, badge: '-15%' },
      { slug: 'crowne', name: 'CROWNE', price: 77.25, originalPrice: 85.83, discount: 10, image: 'https://images.unsplash.com/photo-1539008835657-9e8e9680c956?w=500&q=80', category: 'Best Sellers', sizes: ['XS','S','M','L'], description: 'Regal elegance meets contemporary style in this statement piece.', stock: 12, badge: '-10%' },
      { slug: 'lemonade', name: 'LEMONADE', price: 71.25, originalPrice: 83.83, discount: 15, image: 'https://images.unsplash.com/photo-1518622358385-8ea7d2df44b8?w=500&q=80', category: 'Sale', sizes: ['XS','S','M','L','XL'], description: 'Fresh and vibrant — perfect for summer soirées.', stock: 20, badge: '-15%' },
      { slug: 'rosewood', name: 'ROSE WOOD', price: 77.25, originalPrice: 85.83, discount: 10, image: 'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=500&q=80', category: 'Best Sellers', sizes: ['S','M','L','XL'], description: 'Rich rose tones with intricate wood-inspired detailing.', stock: 15, badge: '-10%' },
      { slug: 'forest', name: 'FOREST', price: 71.25, originalPrice: 83.83, discount: 15, image: 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?w=500&q=80', category: 'Sale', sizes: ['XS','S','M','L'], description: 'Deep emerald hues inspired by enchanted woodland.', stock: 22, badge: '-15%' },
      { slug: 'silver', name: 'SILVER', price: 83.83, image: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=500&q=80', category: 'New Arrivals', sizes: ['XS','S','M','L','XL'], description: 'Shimmering silver threads woven into a luxurious silhouette.', stock: 10 },
      { slug: 'bloom', name: 'BLOOM', price: 89.00, image: 'https://images.unsplash.com/photo-1585487000160-death-to-stock-photography-2?w=500&q=80', category: 'New Arrivals', sizes: ['S','M','L'], description: 'Floral-inspired embroidery on a flowing silhouette.', stock: 8, badge: 'NEW' },
      { slug: 'dusk', name: 'DUSK', price: 95.00, image: 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=500&q=80', category: 'New Arrivals', sizes: ['XS','S','M','L'], description: 'Evening elegance with twilight-inspired palette.', stock: 6, badge: 'NEW' },
      { slug: 'glow', name: 'GLOW', price: 87.00, image: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=500&q=80', category: 'New Arrivals', sizes: ['S','M','L','XL'], description: 'Radiant beauty captured in fabric and form.', stock: 14, badge: 'NEW' },
      { slug: 'nova', name: 'NOVA', price: 92.00, image: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=500&q=80', category: 'New Arrivals', sizes: ['XS','S','M','L'], description: 'Celestial-inspired design with a modern edge.', stock: 9, badge: 'NEW' },
    ];
    this.saveProducts(demos.map(d => ({ ...d, id: crypto.randomUUID(), createdAt: new Date().toISOString() })));

    // Seed demo coupons
    if (!this._get('coupons')) {
      this._set('coupons', [
        { code: 'VERONICA10', type: 'percentage', value: 10, minOrder: null, usageLimit: 100, startDate: null, endDate: null, active: true },
        { code: 'SALE20', type: 'percentage', value: 20, minOrder: 50, usageLimit: 50, startDate: null, endDate: null, active: true },
        { code: 'FLAT15', type: 'fixed', value: 15, minOrder: 75, usageLimit: 30, startDate: null, endDate: null, active: true },
      ]);
    }
  }
};

DB.seed();
