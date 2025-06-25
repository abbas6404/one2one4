import { Button } from "@/components/ui/button"
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from "@/components/ui/accordion"

export default function FAQ() {
  const faqs = [
    {
      question: "How often can I donate blood?",
      answer:
        "You can donate whole blood every 56 days (8 weeks). If you donate platelets, you can give every 7 days up to 24 times a year. Plasma donors can donate every 28 days, and double red cell donors can give every 112 days.",
    },
    {
      question: "Does donating blood hurt?",
      answer:
        "Most people feel only a slight pinch when the needle is inserted. The actual donation process is relatively painless. Our trained staff will do everything possible to make your donation comfortable.",
    },
    {
      question: "How long does a blood donation take?",
      answer:
        "The entire process takes about an hour, though the actual blood donation only takes 8-10 minutes. This includes registration, health screening, donation, and refreshments afterward.",
    },
    {
      question: "Is it safe to donate blood?",
      answer:
        "Yes, it's completely safe. All equipment used is sterile and disposed of after a single use. You cannot contract any disease by donating blood.",
    },
    {
      question: "What should I eat before donating blood?",
      answer:
        "Eat a healthy meal within 2-3 hours before donating. Avoid fatty foods like hamburgers, fries, or ice cream. Include iron-rich foods in your diet, such as red meat, fish, poultry, beans, spinach, or iron-fortified cereals.",
    },
    {
      question: "What happens to my blood after donation?",
      answer:
        "After donation, your blood is tested for blood type and infectious diseases. It's then processed into components (red cells, plasma, platelets) and distributed to hospitals where it's transfused to patients in need.",
    },
  ]

  return (
    <section className="py-16 bg-white">
      <div className="container mx-auto px-4">
        <div className="max-w-3xl mx-auto">
          <h2 className="text-3xl font-bold text-center mb-12">Frequently Asked Questions</h2>

          <Accordion type="single" collapsible className="space-y-4">
            {faqs.map((faq, index) => (
              <AccordionItem
                key={index}
                value={`item-${index}`}
                className="border border-gray-200 rounded-lg overflow-hidden"
              >
                <AccordionTrigger className="px-6 py-4 hover:bg-gray-50 text-left font-medium">
                  {faq.question}
                </AccordionTrigger>
                <AccordionContent className="px-6 py-4 text-gray-600">{faq.answer}</AccordionContent>
              </AccordionItem>
            ))}
          </Accordion>

          <div className="mt-10 text-center">
            <p className="text-gray-600 mb-4">Don't see your question here? Contact us for more information.</p>
            <Button variant="outline" className="border-red-600 text-red-600 hover:bg-red-50">
              Contact Support
            </Button>
          </div>
        </div>
      </div>
    </section>
  )
}
