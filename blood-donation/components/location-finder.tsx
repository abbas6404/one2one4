"use client"

import type React from "react"

import { useState } from "react"
import { Search, MapPin } from "lucide-react"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"

export default function LocationFinder() {
  const [searchQuery, setSearchQuery] = useState("")

  // Mock data for donation centers
  const centers = [
    {
      id: 1,
      name: "Central Blood Bank",
      address: "123 Main Street, Downtown",
      hours: "Mon-Fri: 8am-7pm, Sat: 8am-3pm",
      phone: "(555) 123-4567",
      distance: "0.8 miles",
    },
    {
      id: 2,
      name: "Community Donation Center",
      address: "456 Oak Avenue, Westside",
      hours: "Mon-Fri: 9am-6pm, Sat: 9am-2pm",
      phone: "(555) 987-6543",
      distance: "1.2 miles",
    },
    {
      id: 3,
      name: "Regional Medical Center",
      address: "789 Hospital Drive, Northside",
      hours: "Mon-Sun: 7am-8pm",
      phone: "(555) 456-7890",
      distance: "2.5 miles",
    },
  ]

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault()
    // In a real app, this would filter centers based on location
    console.log("Searching for:", searchQuery)
  }

  return (
    <section className="py-16 bg-gray-50">
      <div className="container mx-auto px-4">
        <div className="max-w-4xl mx-auto">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold mb-4">Find a Donation Center</h2>
            <p className="text-gray-600 max-w-2xl mx-auto">
              Locate the nearest blood donation center in your area. Enter your zip code or city to find centers near
              you.
            </p>
          </div>

          <form onSubmit={handleSearch} className="flex flex-col sm:flex-row gap-3 mb-10">
            <div className="relative flex-grow">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
              <Input
                type="text"
                placeholder="Enter zip code or city"
                className="pl-10"
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
              />
            </div>
            <Button type="submit" className="bg-red-600 hover:bg-red-700">
              Find Centers
            </Button>
          </form>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div className="bg-white rounded-lg shadow-md overflow-hidden">
              <img
                src="/blood-donation-center-map.png"
                alt="Map of donation centers"
                className="w-full h-64 object-cover"
              />
            </div>

            <div className="space-y-4">
              {centers.map((center) => (
                <Card key={center.id}>
                  <CardHeader className="pb-2">
                    <CardTitle className="text-lg flex items-center">
                      <MapPin className="h-5 w-5 text-red-600 mr-2" />
                      {center.name}
                      <span className="ml-auto text-sm font-normal text-gray-500">{center.distance}</span>
                    </CardTitle>
                  </CardHeader>
                  <CardContent>
                    <p className="text-gray-600 text-sm mb-1">{center.address}</p>
                    <p className="text-gray-600 text-sm mb-1">{center.hours}</p>
                    <p className="text-gray-600 text-sm">{center.phone}</p>
                    <Button variant="link" className="text-red-600 p-0 h-auto mt-2">
                      Schedule appointment
                    </Button>
                  </CardContent>
                </Card>
              ))}
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}
