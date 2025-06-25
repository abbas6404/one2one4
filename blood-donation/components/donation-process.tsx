import { Check } from "lucide-react"

export default function DonationProcess() {
  const steps = [
    {
      title: "Registration",
      description: "Sign in, show ID, and fill out a confidential health questionnaire.",
    },
    {
      title: "Health Screening",
      description: "Quick check of temperature, blood pressure, pulse, and hemoglobin levels.",
    },
    {
      title: "Donation",
      description: "The actual donation takes only 8-10 minutes in a comfortable environment.",
    },
    {
      title: "Refreshments",
      description: "Enjoy snacks and drinks while resting for 15 minutes before leaving.",
    },
  ]

  return (
    <section className="py-16 bg-gray-50">
      <div className="container mx-auto px-4">
        <h2 className="text-3xl font-bold text-center mb-12">The Donation Process</h2>

        <div className="max-w-4xl mx-auto">
          <div className="relative">
            {/* Vertical line */}
            <div className="absolute left-4 md:left-8 top-0 bottom-0 w-0.5 bg-red-200"></div>

            {/* Steps */}
            {steps.map((step, index) => (
              <div key={index} className="relative flex items-start mb-12 last:mb-0">
                <div className="absolute left-0 md:left-4 flex items-center justify-center w-8 h-8 md:w-12 md:h-12 rounded-full bg-red-600 text-white z-10">
                  <Check className="w-4 h-4 md:w-6 md:h-6" />
                </div>
                <div className="ml-12 md:ml-20">
                  <h3 className="text-xl md:text-2xl font-semibold mb-2">{step.title}</h3>
                  <p className="text-gray-600">{step.description}</p>
                </div>
              </div>
            ))}
          </div>
        </div>

        <div className="mt-12 text-center">
          <p className="text-lg text-gray-700 max-w-2xl mx-auto">
            The entire process takes about 1 hour, with the actual blood draw only taking 8-10 minutes. Your body
            replaces the fluid in 24 hours and red blood cells within a few weeks.
          </p>
        </div>
      </div>
    </section>
  )
}
