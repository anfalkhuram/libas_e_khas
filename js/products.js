const products = [
  {
    id: 1,
    name: "Walima Pearl Maxi",
    category: "Bridal Wear",
    price: 48500,
    image: "https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&q=80&w=1920",
    hoverImage: "https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&q=80&w=1920",
    images: [
      "https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&q=80&w=1920",
      "https://images.unsplash.com/photo-1605763240000-7e93b172d754?q=80&w=600&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=1920&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1605763240000-7e93b172d754?q=80&w=600&auto=format&fit=crop"
    ],
    sale: false,
    description: "An exquisite bridal maxi featuring heavy zardozi, pearls, and sequence embroidery on premium fabric. Tailored for your most unforgettable day, this piece combines traditional Pakistani craftsmanship with modern elegance.",
    shortDescription: "Heavy zardozi and pearl embroidered bridal maxi.",
    sizes: ["S", "M", "L", "XL", "Custom"],
    fabric: "Premium Net & Raw Silk",
    collection: "Bridal Couture",
    sku: "LK-BW-001",
    availability: "In Stock",
    tags: ["Bridal", "Maxi", "Hand-crafted", "Pearl"],
    rating: 5,
    reviews: 24
  },
  {
    id: 2,
    name: "Crimson Lehnga",
    category: "Bridal Wear",
    price: 65000,
    image: "https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=1920&auto=format&fit=crop",
    hoverImage: "https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=1920&auto=format&fit=crop",
    images: [
      "https://images.unsplash.com/photo-1605763240000-7e93b172d754?q=80&w=600&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=1920&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=1920&auto=format&fit=crop"
    ],
    sale: true,
    salePrice: 58000,
    description: "A stunning crimson red bridal lehnga rich in tradition. Features heavily embellished borders, a classic choli, and an ornately worked dupatta perfect for the classic Pakistani bride.",
    shortDescription: "Classic crimson bridal lehnga with heavy embellishments.",
    sizes: ["S", "M", "L", "XL"],
    fabric: "Raw Silk & Organza",
    collection: "Bridal Couture",
    sku: "LK-BW-002",
    availability: "In Stock",
    tags: ["Bridal", "Lehnga", "Red", "Wedding"],
    rating: 5,
    reviews: 18
  },
  {
    id: 3,
    name: "Emerald Silk Shirt",
    category: "Party Wear",
    price: 18500,
    image: "https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&q=80&w=1920",
    hoverImage: "https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=1920&auto=format&fit=crop",
    images: [
      "https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&q=80&w=1920",
      "https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=1920&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=1920&auto=format&fit=crop"
    ],
    sale: false,
    description: "An elegant pure silk shirt in a rich emerald green, finished with delicate gold threadwork and sequence. A perfect choice for evening gatherings and formal parties.",
    shortDescription: "Pure silk shirt with delicate gold threadwork.",
    sizes: ["XS", "S", "M", "L", "XL"],
    fabric: "Pure Silk",
    collection: "Festive Evening",
    sku: "LK-PW-003",
    availability: "In Stock",
    tags: ["Party", "Silk", "Emerald", "Formal"],
    rating: 4,
    reviews: 32
  },
  {
    id: 4,
    name: "Khuda Baksh Signature",
    category: "Khuda Baksh",
    price: 32000,
    image: "https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=1920&auto=format&fit=crop",
    hoverImage: "https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=1920&auto=format&fit=crop",
    images: [
      "https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=1920&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1605763240000-7e93b172d754?q=80&w=600&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=1920&auto=format&fit=crop"
    ],
    sale: false,
    description: "The signature Khuda Baksh ensemble featuring heritage embroidery techniques revived for the modern era. Luxurious draping and meticulous details define this exclusive piece.",
    shortDescription: "Signature heritage embroidery ensemble.",
    sizes: ["S", "M", "L"],
    fabric: "Organza & Jamawar",
    collection: "Khuda Baksh Exclusive",
    sku: "LK-KB-004",
    availability: "Low Stock",
    tags: ["Signature", "Heritage", "Exclusive"],
    rating: 5,
    reviews: 9
  },
  {
    id: 5,
    name: "Gold Dabka Suit",
    category: "Bridal Wear",
    price: 45000,
    image: "https://images.unsplash.com/photo-1605763240000-7e93b172d754?q=80&w=600&auto=format&fit=crop",
    hoverImage: "https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&q=80&w=1920",
    images: [
      "https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&q=80&w=1920",
      "https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=1920&auto=format&fit=crop"
    ],
    sale: false,
    description: "A mesmerizing formal suit heavily worked with traditional dabka and zari. Designed for closely related wedding guests and trousseau collections.",
    shortDescription: "Traditional dabka and zari worked formal suit.",
    sizes: ["S", "M", "L", "XL"],
    fabric: "Chiffon & Silk",
    collection: "Wedding Formals",
    sku: "LK-BW-005",
    availability: "In Stock",
    tags: ["Dabka", "Gold", "Wedding", "Formal"],
    rating: 5,
    reviews: 14
  },
  {
    id: 6,
    name: "Fancy Gharara",
    category: "Party Wear",
    price: 24000,
    image: "https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&q=80&w=1920",
    hoverImage: "https://images.unsplash.com/photo-1605763240000-7e93b172d754?q=80&w=600&auto=format&fit=crop",
    images: [
      "https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=1920&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=1920&auto=format&fit=crop"
    ],
    sale: true,
    salePrice: 21500,
    description: "A classic heavily embellished gharara paired with a short delicately worked kurti. Perfect for mehndi and dholki events.",
    shortDescription: "Embellished gharara with a delicate kurti.",
    sizes: ["XS", "S", "M", "L"],
    fabric: "Jamawar & Net",
    collection: "Festive Evening",
    sku: "LK-PW-006",
    availability: "In Stock",
    tags: ["Gharara", "Mehndi", "Party"],
    rating: 4,
    reviews: 41
  },
  {
    id: 7,
    name: "Velvet Elegance",
    category: "Khuda Baksh",
    price: 28500,
    image: "https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&q=80&w=1920",
    hoverImage: "https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=1920&auto=format&fit=crop",
    images: [
      "https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=1920&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1605763240000-7e93b172d754?q=80&w=600&auto=format&fit=crop"
    ],
    sale: false,
    description: "Luxurious velvet adorned with antique gold embroidery. A winter wedding essential that speaks volumes of class and sophistication.",
    shortDescription: "Luxurious velvet with antique gold embroidery.",
    sizes: ["M", "L", "XL"],
    fabric: "Premium Velvet",
    collection: "Khuda Baksh Exclusive",
    sku: "LK-KB-007",
    availability: "In Stock",
    tags: ["Velvet", "Winter", "Formal"],
    rating: 5,
    reviews: 11
  },
  {
    id: 8,
    name: "Lawn Suit Classic",
    category: "Party Wear",
    price: 12000,
    image: "https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=1920&auto=format&fit=crop",
    hoverImage: "https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&q=80&w=1920",
    images: [
      "https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=1920&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=1920&auto=format&fit=crop"
    ],
    sale: false,
    description: "Premium lawn with intricate thread embroidery and a digitally printed pure silk dupatta. The quintessential luxury summer wear.",
    shortDescription: "Premium lawn with thread embroidery.",
    sizes: ["S", "M", "L", "XL"],
    fabric: "Luxury Lawn & Silk",
    collection: "Summer Luxury",
    sku: "LK-PW-008",
    availability: "Out of Stock",
    tags: ["Lawn", "Summer", "Casual Luxury"],
    rating: 4,
    reviews: 55
  }
];

// Automatically duplicate to reach 42 items for demonstration purposes
const baseProductCount = products.length;
for (let i = baseProductCount + 1; i <= 42; i++) {
  const baseProduct = products[(i - 1) % baseProductCount];
  products.push({
    ...baseProduct,
    id: i,
    name: `${baseProduct.name} - ${i}`,
    sku: `${baseProduct.sku}-${i}`
  });
}

function formatPrice(price) {
  return "PKR " + price.toLocaleString();
}
